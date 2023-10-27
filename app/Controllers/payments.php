<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\Payment;

class Payments extends Controller
{

    private $_paymentModel;

    function __construct()
    {
        $this->_paymentModel = new Payment();
    }

    function index()
    {
        $data['controller_name'] = strtolower(get_class());
        $data['form_width'] = $this->get_form_width();

        echo view('payments/manage', $data);
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

    function view($paymentID = -1)
    {
        helper(['form']);
        $payment_info = $this->_paymentModel->find($paymentID);
        $data['paymentID'] = $paymentID;
        $data['payment_info'] = $payment_info;
        echo view("payments/form", $data);
    }

    function printReceipt($payment_id = -1)
    {
        $payment = $this->payment->get_info($payment_id);
        $apartment = $this->apartment->get_info($payment->apartment_id);
        $person = $this->Person->get_info($payment->teller_id);
        $user = $this->Person->get_info($this->session->userdata('person_id'));
        $tenant = $this->Person->get_info($payment->tenant_id);

        // pdf viewer 
        $data['payment_id'] = $payment->apartment_payment_id;

        $data['client'] = ucwords($tenant->first_name . " " . $tenant->last_name);

        $data['account'] = $apartment->tenant_id;

        $data['apartment_id'] = $payment->apartment_id;

        $data['amount_paid'] = to_currency($payment->amount, true, 0);

        $data['trans_date'] = date("d/m/Y", strtotime($payment->date_paid));

        $data['paid_by'] = ucwords($payment->paid_by);

        $data['method'] = ucwords($payment->payment_method);

        $data['breakdown'] = json_decode($payment->breakdown);

        $data['teller'] = strtoupper($person->first_name);


        $filename = "payments_" . date("ymdhis");

        // As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/

        $pdf = $this->pdf->load();

        $pdfFilePath = FCPATH . "/downloads/reports/$filename.pdf";

        $html = $this->load->view('payments/receipt', $data, true); // render the view into HTML

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->setAuthor('Vintex technologies');

        $pdf->setTitle('Payment Receipt');

        $pdf->setSubject('Receipt');

        $pdf->Output($pdfFilePath, 'F'); // save to file because we can

        //end of pdf viewer

        $data['pdf_file'] = "downloads/reports/$filename.pdf";


        $this->load->view("payments/manage", $data);
    }


    function printIt($payment_id = -1)
    {
        $payment = $this->payment->get_info($payment_id);
        $apartment = $this->apartment->get_info($payment->apartment_id);
        $person = $this->Person->get_info($payment->teller_id);
        $tenant = $this->Person->get_info($payment->tenant_id);


        // pdf viewer 
        $data['payment_id'] = $payment->apartment_payment_id;

        $data['client'] = ucwords($tenant->first_name . " " . $tenant->last_name);

        $data['account'] = $apartment->tenant_id;

        $data['apartment_id'] = $payment->apartment_id;

        // apartment DETAILS

        $amount_paid = $this->db->select_sum('amount')->where('apartment_id', $payment->apartment_id)->where('UNIX_TIMESTAMP(date_paid) >', strtotime($payment->date_paid))->where('delete_flag', 0)->get('apartment_payments')->row()->amount;

        $apartment_interest = (($apartment->monthly_rate / 30) * $apartment->apartment_amount) * round((time() - strtotime($apartment->date_applied)) / (24 * 60 * 60));

        $data['apartment_balance'] = ($apartment->apartment_amount + $apartment_interest) - $amount_paid;

        $data['amount_paid'] = to_currency($amount_paid, true);

        //apartment DETAILS

        $data['apartment_amount'] = to_currency($apartment->apartment_amount, true);

        $data['interest'] = to_currency($apartment_interest, true);

        $data['expected_payment'] = to_currency($apartment_interest + $apartment->apartment_amount, true);

        $data['paid'] = to_currency($payment->amount, true);

        $data['trans_date'] = date("d/m/Y", strtotime($payment->date_paid));


        $data['new_balance'] = to_currency($data['apartment_balance'] - $payment->amount, true);


        $data['teller'] = $person->first_name . " " . $person->last_name;

        $filename = "payments_" . date("ymdhis");
        // As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
        $pdfFilePath = FCPATH . "/downloads/reports/$filename.pdf";

        $html = $this->load->view('payments/pdf_report', $data, true); // render the view into HTML

        $pdf = $this->pdf->load('UTF-8', 'A4', 9, 'calibri');

        $pdf->SetFooter('@ Rekimu Credit Ltd ' . date('Y') . '<br><small style="color:#eee; font-family:ocrb"> - Generated by apam </small>|{PAGENO}|' . 'Mutungoni Bldg Rm. 32, Mwatu Wa Ngoma Strt');


        $pdf->WriteHTML(file_get_contents('css/style.css'), 1);

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output($pdfFilePath, 'F'); // save to file becase we can

        //end of pdf viewer
        //$data['pdf_file'] = FCPATH ."/downloads/reports/$filename.pdf";
        $data['pdf_file'] = "downloads/reports/$filename.pdf";


        $this->load->view("payments/manage", $data);
    }

    function save($paymentID = -1)
    {
        $payment_data = array(
            'tenant' => $this->request->getPost('tenant'),
            'amount' => $this->request->getPost('amount'),
            'apartment' => $this->request->getPost('apartment'),
            'paymentMethod' => $this->request->getPost('payment_method'),
        );

        if ($paymentID > 0) {
            $apartment_data['apartmentID'] = $paymentID;
        }

        if ($this->_paymentModel->save($payment_data)) {
            echo json_encode(['success' => true, 'message' => 'payment added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'There was a problem updating the payment']);
        }
        
    }

    function delete()
        {
            $paymentID = $this->request->getPost('ids[]');
            // var_dump($paymentID);
            $this->_paymentModel->where('paymentID', $paymentID);

            $success = $this->_paymentModel->delete();

            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Payment deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Sorry, this payment cannot be deleted']);
            }
        }

    

    /*
      get the width for the add/edit form
     */

    function get_form_width()
    {
        return 360;
    }
    
    function data()
    {
        $payments = $this->_paymentModel->findAll();

        $format_result = array();

        foreach ($payments as $payment) {

            $format_result[] = array(
                $payment->paymentID,
                $payment->apartment,
                $payment->tenant,
                $payment->amount,
                $payment->paymentMethod,
                $payment->breakdown,
               
            );
        }
        echo json_encode($format_result);
        exit;
    }
}
