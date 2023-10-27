<?php

namespace App\Controllers;

use App\Models\Setting;
use App\Models\Staff;
use Exception;
use CodeIgniter\Config\Services;

/**
 * Define template file.
 * 
 * @category Controllers
 * @package  Apps\Controllers
 * @author  "Display Name <kelvin@vintextechnologies.com>
 * @license	Not Applicable
 * @link 	Null
 */

class Login extends BaseController
{
	private $_staffModel, $validation, $_otpModel, $_curlStaff, $_settingModel,$_session,$email, $_storeModel;

	function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger) {
		
		parent::initController($request, $response, $logger);

        $this->_settingModel = new Setting();
		$this->_staffModel = new Staff();
        $this->_session = Services::session();
		$this->email = Services::email();

		$this->_curlStaff = \Config\Services::curlrequest();
		
	}

	function index($page = 'login')
	{
		$data['page'] = $page;
			
                
		if ($page == 'reset_password') {
			$data['token'] = $this->request->getVar('t');
		}

		echo view('login', $data);
            
	}
	
	function authenticate() {
		
		if($this->request->getVar("username") != ""){
    				
			$username = $this->request->getVar("username");
			$password = $this->request->getVar("password");

			$staff = $this->_staffModel->Authenticate($username, $password);
			
			if ($staff != null) {
				
				$this->_session->set('apam_staff_id', $staff->staffID);
				
				echo json_encode(array('success' => true, 'message' => 'Login successful. Redirecting...'));
				
			}else{
				echo json_encode(array('success' => false, 'message' => 'Incorrect Credentials! Try Again'));
			}

		}else{
			echo json_encode(array('success' => false, 'message' => 'Invalid Request! Please Try Again'));
		}
	}

	private function _staffExists($phoneNumber){

		$user = $this->_staffModel->where('phone', $phoneNumber)->first();

		if($user == null){
			return false;
		}else{
			return true;
		}
	}
	
	
	public function sendForgotPasswordEmail($page = 'forgot_password')
	{
	$data['page'] = $page;
		if ($this->request->getMethod() === 'post') {
			$rules = [
				'email' => 'required|valid_email'
			];
			if ($this->validate($rules)) {
				$email = $this->request->getPost('email');
				$userData = $this->_staffModel->where('email', $email)->first();
				if ($userData != null && $userData->email == $email) {
					// Generate a reset token and update the user's record
					$tokenHash = bin2hex(random_bytes(32));
					$token = json_encode(["token" => $tokenHash, "expires" => strtotime("+15 minute")]);
					$formData = ['staffID' => $userData->staffID , 'token' => $token];
					if ($this->_staffModel->save($formData)) {
						$data = [
							'firstName' => $userData->firstName,
							'token' =>$tokenHash,
						];
						$message = view('emails/password_reset', $data);
						$this->email->setFrom('support@myshoman.com', 'Shoman Support Team');
						$this->email->setSubject('Password Reset - Shoman');
						$this->email->setTo($email);
						$this->email->setMessage($message);				
						
						if ($this->email->send()) {
							echo json_encode(array('success' => true, 'message' => 'A link has been sent to your to'.$email));
						} else {
							echo json_encode(array('success' => false, 'message' => 'Password reset link failed to send', 'error' => $this->email->printDebugger(['headers'])));
						}
					} else {
						echo json_encode(array('success' => false, 'message' => 'Email not found'));
					}
				} else {
					$data['validation'] = $this->validator;
				}
			}
		}
		
		echo view('login', $data);
	}
	
	public function change_password($page = 'reset_password'){
		$data['page'] = $page;
		$token =  $this->request->getVar('token');
		$data['token'] = $token;
		echo view('login', $data);
	}
	public function changePassword()
	{
		
		
		$token =  $this->request->getVar('token');
		$data['token'] = $token;

		if (!empty($token)) {
			$staff = $this->_staffModel->like('token', $token)->first();
		
			if ($staff != null) {
				$decodedToken = json_decode($staff->token);
			
				if ($decodedToken !== null && $decodedToken->expires >= time()) {
							
					$userData = [
						'staffID' => $staff->staffID,
						'password' => md5($this->request->getVar('password') . ""),
						'token' => null
					];
					
					$validationRules = ['password'     => 'required|min_length[8]'];	
					if (!$this->validate($validationRules)) {
						echo json_encode(array('success' => false, 'message' => 'Password must be at least 8 characters long'));
					}
					if ($this->_staffModel->save($userData)) {

						echo json_encode(array('success' => true, 'message' => 'Password reset successfully'));
					} else {

						echo json_encode(array('success' => false, 'message' => 'Password reset failed'));
					}
				} else {

					echo json_encode(array('success' => false, 'message' => 'Reset link is expired'));
				}
			} else {

				echo json_encode(array('success' => false, 'message' => 'user not found'));
			}
		} else {

			echo json_encode(array('success' => false, 'message' => 'Unauthorised access'));
		}
	
	}
	

}