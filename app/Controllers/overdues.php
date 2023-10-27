<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Apartment;

class Overdues extends Controller
{
    private $apartment;

    public function __construct()
    {
        $this->apartment = new Apartment();
    }
    function index()
    {
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();
        echo view('apartments/overdues', $data);
    }

    function search()
    {
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest()
    {
    }

    function get_row()
    {
    }

    function view($apartment_id = -1)
    {
        $data['apartment_info'] = $this->apartment->get_info($apartment_id);

        $apartment = $this->apartment->get_info($apartment_id);

        // tenantS COLLATERALS

        $data['collaterals'] = json_decode($data['apartment_info']->collaterals, true);

        //GUARANTORS INFO

        $data['person_info_g'] = json_decode($apartment->guarantor)[0];

        $data['person_info_r'] = json_decode($apartment->referee)[0];


        // GUARANTORS COLLATERALS

        $data['collaterals_g'] = json_decode($apartment->collaterals_g, true);


        // PAYABLE AMOUNT

        $data['amount_paid'] = $this->db->select_sum('amount')->where('apartment_id', $apartment->apartment_id)->get('apartment_payments')->row()->amount;

        $apartment_interest = (($apartment->monthly_rate / 30) * $apartment->apartment_amount) * round((time() - strtotime($apartment->date_applied)) / (24 * 60 * 60));

        $balance = ($apartment->apartment_amount + $apartment_interest) - $data['amount_paid'];

        $data['apartment_balance'] = ($balance > 0) ? $balance : 0;

        //PAYMENT STATUS

        if ($data['apartment_balance'] > 0) {

            $apartment_status = 'On payment';
        } else if ($data['apartment_balance'] == 0) {

            $apartment_status = 'Paid';
        } else if ($data['apartment_balance'] == $apartment->apartment_amount) {

            $apartment_status = 'Unpaid';
        }

        $data['apartment_status'] = $apartment_status;

        //tenant NAME

        $tenant = $this->tenant->get_info($apartment->tenant_id);

        $data['tenant_name'] = ($apartment_id > 0) ? $tenant->first_name . ' ' . $tenant->last_name : '';


        $staffs = $this->staff->get_all()->result();

        $emps = array();

        foreach ($staffs as $staff) {
            $emps[$staff->person_id] = $staff->first_name . " " . $staff->last_name;
        }

        $data['staffs'] = $emps;

        $this->load->view("apartments/form", $data);
    }

    function save($apartment_id = -1)
    {
    }

    function delete()
    {
    }

    /*
      get the width for the add/edit form
     */

    function get_form_width()
    {
        return 360;
    }

    function data($status = "overdue")
    {

        $sel_user = $this->input->get("staff_id");

        $order = array("index" => $_GET['order'][0]['column'], "direction" => $_GET['order'][0]['dir']);

        $apartments = $this->apartment->get_all($_GET['length'], $_GET['start'], $_GET['search']['value'], $order, $status, $sel_user);

        $format_result = array();

        //GET LATEST PRINCIPAL AND INTEREST

        $apartment_payments = $this->db->where('apartment_id', $apartment->apartment_id)->where('delete_flag', 0)->order_by('date_paid', 'asc')->get('apartment_payments')->result();

        $principal = $apartment->apartment_amount;

        $start_time = strtotime($apartment->date_applied);

        $overall_interest = $paid_penalty = 0;

        $count = 1;

        foreach ($apartment_payments as $payment) {

            // echo "<p>Principal ".$count.": ".$principal;

            $end_time = strtotime($payment->date_paid);

            $duration = round($end_time - $start_time) / (24 * 60 * 60);

            // echo "<br>Duration ".$count.": ".$duration." Days";

            $interest = $principal * $duration * ($apartment->monthly_rate / 30);

            // echo "<br>Interest ".$count.": ".to_currency($interest, true, 0);

            $overall_interest += $interest;


            $breakdown = json_decode($payment->breakdown);

            $principal = $principal - $breakdown->principal;

            $overall_interest -= $breakdown->interest;

            $paid_penalty += $breakdown->penalty;

            $start_time = $end_time;

            $count++;
        }

        $end_time = strtotime($payment->date_paid);

        $duration = (strtotime(date('Y-m-d', time())) - $start_time) / (24 * 60 * 60);

        $interest = $principal * $duration * ($apartment->monthly_rate / 30);

        $overall_interest += $interest;


        // PAYABLE AMOUNT

        $days_late = 0;

        $penalty = 0;

        $amount_paid = $this->db->select_sum('amount')->where('apartment_id', $apartment->apartment_id)->where('delete_flag', 0)->get('apartment_payments')->row()->amount;

        $apartment_balance = ($principal + $overall_interest);

        if (time() - (24 * 60 * 60) > strtotime($apartment->payment_date)) {

            $days_late = round((strtotime(date('Y-m-d', time())) - strtotime($apartment->payment_date)) / (24 * 60 * 60));

            $penalty = $apartment->penalty_rate * $overall_interest;

            $penalty = $apartment_balance + $penalty;
        }

        if ($apartment_balance > 0) {

            $format_result[] = array(
                "<input type='checkbox' name='chk[]' id='apartment_$apartment->apartment_id' value='" . $apartment->apartment_id . "'/>",
                $apartment->apartment_id,
                $apartment->tenant_id,
                $apartment->description,
                to_currency($apartment->apartment_amount),
                to_currency($data['apartment_balance']),
                ucwords($apartment->tenant_name),
                ucwords($apartment->agent_name),
                date("d M Y", strtotime($apartment->date_applied)),
                date("d M Y", strtotime($apartment->payment_date)),

                '<span style="cursor: pointer" title="Bal: Ksh. ' . number_format($data["apartment_balance"]) . '">' . ucfirst($apartment_status) . '</span>',

                "<div style='display:flex; align-items:center'>" . anchor('apartments/view/' . $apartment->apartment_id, '<span class="fa fa-search-plus"></span>', array('class' => 'btn-success btn-sm effect-1', 'title' => 'apartment details')) . "</div>"
            );
        }

        echo json_encode($data);

        exit;
    }

    function overdues()
    {
        $order = array("index" => $_GET['order'][0]['column'], "direction" => $_GET['order'][0]['dir']);

        $apartments = $this->apartment->get_all($_GET['length'], $_GET['start'], $_GET['search']['value'], $order, "overdue");

        $format_result = array();

        foreach ($apartments->result() as $apartment) {
            $apartment_status = $apartment->apartment_status;
            if ($apartment->apartment_balance <= 0) {
                $apartment_status = "Paid";
            }

            $balance = ($apartment->monthly_rate * $apartment->apartment_amount) * round((strtotime($apartment->payment_date) - strtotime($apartment->date_applied)) / (30 * 24 * 60 * 60));

            $balance = ($balance > 0) ? $balance : 0;


            $format_result[] = array(
                "<input type='checkbox' name='chk[]' id='apartment_$apartment->apartment_id' value='" . $apartment->apartment_id . "'/>",
                $apartment->apartment_id,
                $apartment->tenant_id,
                $apartment->description,
                to_currency($apartment->apartment_amount),
                to_currency($balance),
                ucwords($apartment->tenant_name),
                ucwords($apartment->agent_name),
                //ucwords($apartment->approver_name),
                date("m/d/Y", strtotime($apartment->date_applied)),
                date("m/d/Y", strtotime($apartment->payment_date)),
                $this->lang->line("common_" . strtolower($apartment_status)),
                "<div style='display:flex; align-items:center'>" . anchor('apartments/view/' . $apartment->apartment_id, '<span class="fa fa-search-plus"></span>', array('class' => 'btn-info btn-sm effect-1', 'title' => 'apartment details')) . "</div>"
            );
        }

        $data = array(
            "recordsTotal" => $this->apartment->count_all(),
            "recordsFiltered" => $this->apartment->count_all(),
            "data" => $format_result
        );

        echo json_encode($data);
        exit;
    }


    private function _count_overdues()
    {
        return $this->apartment->count_overdues();
    }

    function tenant_search()
    {
        $suggestions = $this->tenant->get_tenant_search_suggestions($this->input->get('query'), 30);
        $data = $tmp = array();

        foreach ($suggestions as $suggestion) :
            $t = explode("|", $suggestion);
            $tmp = array("value" => $t[1], "data" => $t[0]);
            $data[] = $tmp;
        endforeach;

        echo json_encode(array("suggestions" => $data));
        exit;
    }

    function select_tenant()
    {
        $tenant_id = $this->input->post("tenant");
        $this->sale_lib->set_tenant($tenant_id);
        $this->_reload();
    }

    function upload()
    {
        $directory = FCPATH . 'uploads/apartment-' . $_REQUEST["apartment_id"] . "/";
        $this->load->library('uploader');
        $data = $this->uploader->upload($directory);

        $this->apartment->save_attachments($data['params']['apartment_id'], $data);

        $file = $this->_get_formatted_file($data['attachment_id'], $data['filename'], "");
        $file['apartment_id'] = $data['params']['apartment_id'];
        $file['id'] = $data["attachment_id"];

        echo json_encode($file);
        exit;
    }

    function remove_file()
    {
        $file_id = $this->input->post("file_id");
        echo json_encode(array("status" => $this->apartment->remove_file($file_id)));
        exit;
    }

    function attach_desc()
    {
        $id = $this->input->post("attach_id");
        $desc = $this->input->post("desc");
        $this->apartment->save_attach_desc($id, $desc);
        echo json_encode(array("success" => TRUE));
        exit;
    }

    function attachments($apartment_id, $select_type)
    {
        $data['apartment_info'] = $this->apartment->get_info($apartment_id);
        $attachments = $this->apartment->get_attachments($apartment_id);

        $file = array();
        foreach ($attachments as $attachment) {
            $file[] = $this->_get_formatted_file($attachment->attachment_id, $attachment->filename, $attachment->descriptions);
        }

        $data["select_type"] = $select_type;
        $data['attachments'] = $file;
        $this->load->view("apartments/attachments", $data);
    }
}
