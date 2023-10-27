<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Controllers\interfaces\iData_controller;
use App\Models\Apartment;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class apartments extends BaseController
{
    private $_apartmentModel;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->_apartmentModel = new Apartment();
    }
    function index()
    {
        $data['controller_name'] = strtolower(get_class());
        $data['apartments'] = $this->_apartmentModel->orderBy('apartmentID', 'DESC')->get();
        echo view('apartments/manage', $data);
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

    function view($apartmentID = -1)
    {
        $data['houseTypes'] = $this->_apartmentModel->distinct()->select('houseTypes')->get()->getResultArray();
        $data['apartmentStatus'] = $this->_apartmentModel->distinct()->select('apartmentStatus')->get()->getResultArray();

        $apartment_info = $this->_apartmentModel->find($apartmentID);
        $data['apartmentID'] = $apartmentID;
        $data['apartment_info'] = $apartment_info;
        echo view("apartments/form", $data);
    }

    private function _get_files($ids, $file)
    {
        $tmp = array();
        if (is_array($ids)) {
            foreach ($ids as $id) :
                $tmp[] = $file[$id];
            endforeach;
        }

        return $tmp;
    }

    function save($apartmentID = -1)
    {
        $apartment_data = array(
            'apartmentName' => $this->request->getPost('apartmentName'),
            'description' => $this->request->getPost('description'),
            'apartmentStatus' => $this->request->getPost('apartmentStatus'),
            'houseTypes' => $this->request->getPost('houseTypes'),
            'unitsCount' => $this->request->getPost('unitsCount'),
        );

        if ($apartmentID > 0) {
            $apartment_data['apartmentID'] = $apartmentID;
        }

        if ($this->_apartmentModel->save($apartment_data)) {
            echo json_encode(['success' => true, 'message' => 'apartment added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'There was a problem updating the apartment']);
        }
        
    }




    function delete()
    {
        $apartmentID = $this->request->getPost('ids[]');

        $success = $this->_apartmentModel->delete($apartmentID);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Apartment deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Sorry, this apartment cannot be deleted']);
        }
    }


    function data()
    {
        $apartments = $this->_apartmentModel->orderBy('apartmentID', 'DESC')->findAll();
        $format_result = array();
        foreach ($apartments as $apartment) {
            $format_result[] = array(
                $apartment->apartmentID,
                $apartment->apartmentName,
                $apartment->description,
                $apartment->apartmentStatus,
                $apartment->houseTypes,
                $apartment->unitsCount,
            );
        }
        echo json_encode($format_result);
        exit;
    }

    function upload()
    {
        $directory = FCPATH . 'uploads/apartment-' . $_REQUEST["apartment_id"] . "/";
        $this->load->library('uploader');
        $data = $this->uploader->upload($directory);

        $this->_apartmentModel->save_attachments($data['params']['apartment_id'], $data);

        $file = $this->_get_formatted_file($data['attachment_id'], $data['filename'], "");
        $file['apartment_id'] = $data['params']['apartment_id'];
        $file['id'] = $data["attachment_id"];

        echo json_encode($file);
        exit;
    }

    function remove_file()
    {
        $file_id = $this->input->post("file_id");
        echo json_encode(array("status" => $this->_apartmentModel->remove_file($file_id)));
        exit;
    }

    function attach_desc()
    {
        $id = $this->input->post("attach_id");
        $desc = $this->input->post("desc");
        $this->_apartmentModel->save_attach_desc($id, $desc);
        echo json_encode(array("success" => TRUE));
        exit;
    }

    function attachments($apartment_id, $select_type)
    {
        $data['apartment_info'] = $this->_apartmentModel->get_info($apartment_id);
        $attachments = $this->_apartmentModel->get_attachments($apartment_id);

        $file = array();
        foreach ($attachments as $attachment) {
            $file[] = $this->_get_formatted_file($attachment->attachment_id, $attachment->filename, $attachment->descriptions);
        }

        $data["select_type"] = $select_type;
        $data['attachments'] = $file;
        $this->load->view("apartments/attachments", $data);
    }
}
