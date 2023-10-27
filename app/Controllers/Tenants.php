<?php

namespace App\Controllers;

use App\Models\Person;
use App\Models\Tenant;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class tenants extends BaseController
{
    private $_tenantModel;
    private $_personModel;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->_tenantModel = new Tenant();
        $this->_personModel = new Person();
    }

    public function index()
    {

        $data['controller_name'] = strtolower(get_class());
        $data['tenants'] = $this->_tenantModel->orderBy('tenantID', 'DESC')->get();

        return view('people/manage', $data);
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    function suggest()
    {
        //$suggestions = $this->tenant->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
        $suggestions = $this->tenant->get_search_suggestions($this->input->post('query'), 30);
        //echo implode("\n", $suggestions);

        $data = $tmp = array();

        foreach ($suggestions as $suggestion) :
            $t = explode("|", $suggestion);
            $tmp = array("value" => $t[1], "data" => $t[0]);
            $data[] = $tmp;
        endforeach;

        echo json_encode(array("suggestions" => $data));
        exit;
    }

    public function get_payment_history($tenantID)
    {
        $payment_ids = $this->tenant->get_payment_ids($tenant_id);

        $ids = array();

        foreach ($payment_ids as $id) {

            array_push($ids, $id["payment_id"]);
        }

        if (sizeof($ids) > 0) {

            $payment_history = $this->payment->get_multiple_info($ids);

            $i = 0;
        }

        return $payment_history;
    }

    /*
      Loads the tenant edit form
    */

    function view($tenantID = -1)
    {
        $tenant_info = $this->_tenantModel->find($tenantID);
        $data['tenantID'] = $tenantID;
        $data['tenant_info'] = $tenant_info;
        echo view("tenants/form", $data);
    }
    /*
      Inserts/updates a tenant
     */

    function save($tenantID = -1)
    {
        $person_data = array(
            'firstName' => $this->request->getPost('first_name'),
            'lastName' => $this->request->getPost('last_name'),
            'emailAddress' => $this->request->getPost('email'),
            'IDNumber' => $this->request->getPost('id_number'),
            'phoneNumber' => $this->request->getPost('phone_number'),
            'homeAddress' => $this->request->getPost('home_address'),
            'physical_address' => $this->request->getPost('physical_address'),
            'occupation' => $this->request->getPost('employer'),
            'occupation' => $this->request->getPost('occupation'),
            'income' => $this->request->getPost('income')
        );


        if ($tenantID == -1) {
            $inserted_tenant_id = $this->_tenantModel->save($person_data);

            if ($inserted_tenant_id !== false) {
                $response = ['success' => true, 'message' => 'Tenant added successfully'];
            } else {
                $response = ['success' => false, 'message' => 'There was a problem adding the tenant'];
            }
        } else {
            if ($this->_tenantModel->update($tenantID, $person_data)) {
                $response = ['success' => true, 'message' => 'Tenant updated successfully'];
            } else {
                $response = ['success' => false, 'message' => 'There was a problem adding the tenant'];
            }
        }
        echo json_encode($response);
        exit;
    }

    function delete()
    {
        $tenantID = $this->request->getPost('ids[]');

        $success = $this->_tenantModel->delete($tenantID);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Tenant deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Sorry, this Tenant cannot be deleted']);
        }
    }
    function data()
    {
        $tenants = $this->_tenantModel->orderBy('tenantID', 'DESC')->findAll();
        $format_result = array();
        foreach ($tenants as $tenant) {
            $format_result[] = array(
                $tenant->tenantID,
                $tenant->firstName,
                $tenant->lastName,
                $tenant->IDNumber,
                $tenant->phoneNumber,
                $tenant->occupation,
                $tenant->homeAddress,
            );
        }

        echo json_encode($format_result);
        exit;
    }

    function getTenant($tenant_id)
    {

        $tenantData = $this->_tenantModel->find($tenant_id);
        var_dump($tenantData);
        exit;
        return $tenantData;
    }
}
