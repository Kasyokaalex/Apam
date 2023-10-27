<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\apartment;
use App\Models\expense;
use App\Models\payment;
use App\Models\Staff;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Home extends Controller
{

    protected $apartment;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = \Config\Services::session();

        $this->staff = new Staff();
        $this->apartment = new apartment();
        $this->expense = new expense();
        $this->payment = new payment();
    }

    function index($startDate = '', $endDate = '', $duration = '')
    {
        // $data["total_apartments"] = json_decode($this->apartment->get_total_apartments_by_range($startDate , $endDate))[0];

        // $data['apartment_increase'] = json_decode($this->apartment->get_total_apartments_by_range($startDate , $endDate))[1]."%";

        // $apartment_status = json_decode($this->apartment->get_total_apartments_by_range($startDate , $endDate))[2];


        // if ($apartment_status === "decrease") {

        //     $data['apartment_increase'] .= "<i class='fa fa-level-down'></i>";

        // }else{

        //     $data['apartment_increase'] .= "<i class=' lnr lnr-arrow-up'></i>";
        // }

        // $data["expense"] = json_decode($this->expense->get_total_by_range($startDate , $endDate))[0];

        // $data['expense_increase'] = json_decode($this->expense->get_total_by_range($startDate , $endDate))[1]."%";

        // $apartment_status = json_decode($this->expense->get_total_by_range($startDate , $endDate))[2];

        // $expense_breakdown = json_decode($this->expense->get_total_by_range($startDate , $endDate))[3];


        // if ($apartment_status === "decrease") {

        //     $data['expense_increase'] .= "<i class='fa fa-level-down'></i>";

        // }else{

        //     $data['expense_increase'] .= "<i class=' lnr lnr-arrow-up'></i>";
        // }


        // $data["payment_total"] = json_decode($this->payment->get_total_by_range($startDate , $endDate))[0];

        // $data['payment_increase'] = json_decode($this->payment->get_total_by_range($startDate , $endDate))[1]."%";

        // $apartment_status = json_decode($this->payment->get_total_by_range($startDate , $endDate))[2];

        // $payment_breakdown = json_decode($this->payment->get_total_by_range($startDate , $endDate))[3];


        // if ($apartment_status === "decrease") {

        //     $data['payment_increase'] .= "<i class='fa fa-level-down'></i>";

        // }else{

        //     $data['payment_increase'] .= "<i class=' lnr lnr-arrow-up'></i>";
        // }

        // // income = payments

        // $income = json_decode($this->payment->get_total_by_range($startDate , $endDate))[4];

        // $data['income'] = $income;

        // // expenses = apartments + expenses

        // $expenditure = $data['expense'];

        // $data['expenditure'] = $expenditure;

        // // profit = income - expenses

        // $profit = $income - $expenditure;

        // $data['profit'] = $profit;


        // if (strlen($duration) > 3) {

        //     echo json_encode(array(

        //         "duration" => urldecode($duration),

        //         "total_apartments" => ($data['total_apartments'] > 0) ? to_currency($data['total_apartments'], true, 0) : 'Ksh. 0',

        //         "apartment_increase" => $data['apartment_increase'], 

        //         "expense" => ($data['expense'] > 0) ? to_currency($data['expense'], true, 0) : 'Ksh. 0',

        //         "expense_increase" => $data['expense_increase'], 

        //         "expense_breakdown" => $expense_breakdown, 

        //         "payments" => ($data['payment_total'] > 0) ? to_currency($data['payment_total'], true, 0) : 'Ksh. 0', "payment_increase" => $data['payment_increase'] ,

        //         "payment_breakdown" => $payment_breakdown, 

        //         "income" => ($data['income'] > 0) ? to_currency($data['income'], true, 0) : 'Ksh. 0',

        //         "expenditure" => ($data['expenditure'] > 0) ? to_currency($data['expenditure'], true, 0) : 'Ksh. 0',

        //         "profit" => ($data['profit'] != 0) ? to_currency($data['profit'], true, 0) : 'Ksh. 0'
        //     ));

        // }else{

        return view('home');
    }

    function logout()
    {
        $this->session->destroy();

        redirect()->to(base_url());
    }
}
