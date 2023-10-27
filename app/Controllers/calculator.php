<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class Calculator extends Controller {

    function __construct()
    {
        parent::__construct('letters');

    }

    function index()
    {
        $data['controller_name'] = strtolower(get_class());
                    
        $this->load->view('apartments/calculator');

        $this->load->view('partial/footer');
    }
}