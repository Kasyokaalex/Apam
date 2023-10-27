<?php

namespace App\Controllers;

use App\Models\Staff;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


class Config extends Controller
{
    private $staff;

    private $_apartmentModel;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    function index()
    {

        $data = [];
        echo view("config");
    }

    function save()
    {
        $batch_save_data = [
            'company' => $this->request->getPost('company'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'fax' => $this->input->post('fax'),
            'website' => $this->input->post('website'),
            'currency_symbol' => $this->input->post('currency_symbol'),
            'currency_side' => $this->input->post('currency_side'),
            'language' => $this->input->post('language'),
            'timezone' => $this->input->post('timezone')
        ];

        $smtp_data = [
            "smtp_id" => $this->input->post("smtp_id"),
            "smtp_host" => $this->input->post("smtp_host"),
            "smtp_port" => $this->input->post("smtp_port"),
            "smtp_user" => $this->input->post("smtp_user"),
            "smtp_pass" => $this->input->post("smtp_pass"),
        ];

        if ($this->Appconfig->batch_save($batch_save_data)) {
            // saving SMTP settings             
            // $this->Email->save_smtp($smtp_data);
            echo json_encode(array('success' => true, 'message' => 'Configurations saved successfully'));
        }
    }

    function upload()
    {
        $directory = FCPATH . "uploads/logo/";
        $this->load->library('uploader');
        $data = $this->uploader->upload($directory);

        $this->Appconfig->save("logo", $data['filename']);
        $data['company_name'] = strtolower(preg_replace('/\s+/', '', config('apamSettings')->company));

        echo json_encode($data);
        exit;
    }

    function backup()
    {
        $this->load->dbutil();

        $format = array('format' => 'zip', 'file_name' => 'jk_db_backup.sql;');

        $backup = &$this->dbutil->backup($format);

        $db_name = "jk_" . date('dmYhi') . ".zip";

        $save = "downloads/" . $db_name;

        if (write_file($save, $backup)) {

            $str = file_get_contents("backup_logs.json", true);

            $logs = json_decode($str);

            $file_dits = array('name' => $db_name, 'time_stamp' => time(), "backup_by" => $this->session->userdata('person_id'));

            array_push($logs, $file_dits);

            $new_logs = json_encode($logs);

            file_put_contents("backup_logs.json", $new_logs);

            force_download($db_name, $backup);
        }
    }
}
