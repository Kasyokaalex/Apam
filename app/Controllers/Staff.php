<?php

namespace App\Controllers;

use App\Libraries\Uploader;
use App\Models\Staff as ModelsStaff;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use stdClass;

class Staff extends BaseController {

    protected $_staffModel, $_customerModel;
    protected $_session, $_userID, $_userData;
    
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
        
		
		$this->_staffModel = new ModelsStaff();        
        
		
		
	}

    function index()
    {

        if(config('loggedInStaff')->role != "admin"){

            return redirect()->to(base_url() ."/staff/view/".config('loggedInStaff')->staffID );
        }
        // $data['staff'] = $res;
        
        $data['controller_name'] = 'staff';
       
        echo View('staff/manage', $data);
    }

    /*
      Returns staff table data rows. This will be called with AJAX.
     */

    function search()
    {
       
    }

    /*
      Only admins or management can delete sales
     */

    function can_delete_sale($username = "", $password = "")
    {
        $staff = $this->_staffModel->where('username', $username)->where('password', md5($password))->first();
        
        echo ($staff != null && ($staff->role == "admin" || $staff->role == "mgmt")) ? 'true' : 'false';
    }

    function can_modify_user($staffID)
    {
        
    }

    /*
      Loads the staff edit form
     */

    function view($staffID = -1)
    {
    
        
        $data['controller_name'] = 'Staff';
        
        if($staffID > -1){
            
            $data['staffData'] = $this->_staffModel->find($staffID);
            
        }else{
            
            $data['staffData'] = new stdClass();
        }
        
        $data['staffID'] = $staffID;
        
        echo View("staff/form", $data);
    }

    /*
      Inserts/updates an staff
     */

    function save()
    {
        $staffID = $this->request->getPost('staffID');
        
        $staff_data = array(
            'photo' => $this->request->getPost('photo'),
            'firstName' => $this->request->getPost('firstName'),
            'lastName' => $this->request->getPost('lastName'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'IDNumber' => $this->request->getPost('IDNumber'),
            'homeAddress' => $this->request->getPost('homeAddress'),    
        );
        
        if($staffID !=config('loggedInStaff')->staffID) $staff_data['role'] = $this->request->getPost('role'); // Can't Change my Role

        if($staffID > 0) $staff_data['staffID'] = $staffID; // If we are editing an existing user

        // Password has been changed OR first time password set
        if ($this->request->getPost('password') != '')
        {
            $staff_data['username'] = $this->request->getPost('username');
            $staff_data['password'] = md5($this->request->getPost('password'));
            
        }
        else //Password not changed
        {
            $staff_data['username'] = $this->request->getPost('username');
        }
        
        // CHECK IF A USER WITH SAME PHONE or USERNAME or ID NUMBER EXISTS
        
        $exists = $this->_staffModel->where('username', $staff_data['username'])->orWhere('phone', $staff_data['phone'])->orWhere('IDNumber', $staff_data['IDNumber'])->first();
        
        if($exists != null && $staffID < 1){ // Don't save is user exists
            
            echo json_encode(array('success' => false, 'message' => 'Error! Staff with the same Phone Number, Username or ID Number already exists', 'staffID' => -1));
            
            exit;
        }

        if ($this->_staffModel->save($staff_data))
        {
            //New staff
            if ($staffID == -1)
            {
                echo json_encode(array('success' => true, 'message' => 'Staff Added Successfully', 'staffID' => $staffID));
            }
            else //previous staff
            {
                echo json_encode(array('success' => true, 'message' => 'Staff updated successfully ', 'staffID' => $staffID));
            }
        }
        else//failure
        {
            echo json_encode(array('success' => false, 'message' => 'Oooops! An error occured while updating data', 'staffID' => -1));
        }
    }

    /*
      This deletes staff from the staff table
     */

    function delete()
    {
        $staff_to_delete = $this->request->getPost('ids');

        if ($this->_staffModel->delete($staff_to_delete))
        {
            echo json_encode(array('success' => true, 'message' => "Staff successfully deleted !"));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => "Staff cannot be deleted"));
        }
    }

    /*
      get the width for the add/edit form
     */

    function get_form_width()
    {
        return 650;
    }

    function getAll()
    {
        
        $staff = $this->_staffModel->findAll();

        // var_dump($staff);

        $format_result = [];

        foreach ($staff as $person)
        {

            if(config('loggedInStaff')->role != "mgmt"){
                
                

                $format_result[] = array(
                    $person->lastName ." ".$person->firstName,
                    $person->phone,
                    $person->idNumber,
                    '<span class="text-danger">Deleted</span>',
                    $person->email,
                    $person->staffID
                );
            }
        }

        echo json_encode($format_result);
        exit;
    }
    
    function getRow($staffID = -1)
    {
        $staff = $this->_staffModel->find($staffID);
        $staff->password = "Heheeee!";

        if($staff->role == 'admin'){

            $staff->role_name = "Administrator";

            $staff->label = "danger";

        }else if($staff->role == "mgmt"){

            $staff->role_name = "Management";

            $staff->label = "success";

        }else{                  

            $staff->role_name = "Basic User";

            $staff->label = "info";
        }
        
        echo json_encode($staff);
        exit;
    }
    
    function staff_search()
    {
        $suggestions = $this->staff_model->get_staff_search_suggestions($this->input->get('query'), 30);
        $data = $tmp = [];

        foreach ($suggestions as $suggestion):
            $t = explode("|", $suggestion);
            $tmp = array("value" => $t[1], "data" => $t[0], "email" => $t[2]);
            $data[] = $tmp;
        endforeach;

        echo json_encode(array("suggestions" => $data));
        exit;
    }
           
    function uploadProfilePic($staffID = -1)
    {
        $directory = FCPATH."/public/uploads/staff";
        
        if(!is_dir($directory)){ // CREATE THE DIRECTORY IF IT DOESN'T EXIST
            mkdir($directory, 0777, true);
        }
        
        $uploader = new Uploader();
            
        $data = $uploader->upload($directory);
        
        $staffData = array(
            "staffID" => $staffID, 
            "photo" => $data['filename']
        );
        
        if($staffID > 0){
            
            $staffPhoto = $this->_staffModel->find($staffID)->photo;
            
            if(is_file($directory. '/'. $staffPhoto)) unlink($directory. '/'. $staffPhoto); // Remove Old Photo

            $this->_staffModel->save($staffData);
        }
            
        echo json_encode(["status" => "OK"]);
        exit;
        
    }


}

?>