<?php

namespace App\Controllers;

use App\Models\Report;
use App\Models\Person;
use App\Models\Staff;
use App\Models\Apartment;
use App\Models\Payment;
use App\Models\Tenant;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Dompdf\Dompdf;

use function PHPSTORM_META\type;

class Reports extends BaseController
{

    private $report;
    private $person;
    private $apartment;
    private $payments;
    private $tenant;
    private $staff;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->report = new Report();
        $this->person = new Person();
        $this->apartment = new Apartment();
        $this->payments = new Payment();
        $this->tenant = new Tenant();
        $this->staff = new Staff();
    }

    function index()
    {

        $data['controller_name'] = strtolower(get_class());

        $data['report_types'] = array('staffs', 'apartments', 'apartment_payments', 'tenants');

        echo view('reports/manage', $data);
    }

    public function staffs($from = '', $to = '')
    {


        $this->staff->join('people', 'people.person_id = staffs.person_id');


        $data['data'] = $this->staff->get()->result();

        //var_dump($data['data']);

        echo view('reports/manage', $data);
    }




    function printIt($type = 'apartments')
    {

        $apartments = $this->apartment->findAll();
        $person = new Person();

        $data['teller'] = $person->first_name . " " . $person->last_name;

        $data['report_types'] = array('staffs', 'apartments', 'apartment_payments', 'tenants');

        $filename = $type . "_" . date("ymdhis");
        // As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
        $pdfFilePath = FCPATH . "/downloads/reports/$filename.pdf";

        ini_set('memory_limit', '32M'); // boost the memory limit if it's low <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">

        if ($type == 'tenants' || $type == 'staff') {
            $staff = $this->staff->findAll();
            $this->staff->join($type, $type . '.person_id = people.person_id');

            $data['data'] = $this->staff->get()->result();
            echo view('reports/people_report', ['data' => $data]);
        } else if ($type == 'apartments') {

            $apartment = $this->apartment->findAll();

            $Output = '';

            $count = 1;

            foreach ($apartments as $apartment) {
                echo view('reports/people_report', ['type' => $type]);
            }

            $data['apartment_data'] = $Output;
        } else if ($type == 'apartment_payments') {

            $payments = $this->payments->findAll();

            $Output = '';

            $count = 1;

            foreach ($payments as $payment) {

                $apartment = $this->apartment->where('apartment_id', $payment->apartment_id)->get('apartments')->row();
                $tenant = new Tenant();
                $tenant = ucwords($tenant->first_name . " " . $tenant->last_name);

                // apartment DETAILS

                $amount_paid = $this->payments->select_sum('amount')->where('apartment_id', $payment->apartment_id)->where('UNIX_TIMESTAMP(date_paid) >=', strtotime($payment->date_paid))->get('apartment_payments')->row()->amount;

                $apartment_interest = (($apartment->monthly_rate) * $apartment->apartment_amount) * round((strtotime($apartment->payment_date) - strtotime($apartment->date_applied)) / (30 * 24 * 60 * 60));

                $apartment_balance = ($apartment->apartment_amount + $apartment_interest) - $amount_paid;

                $trans_date = date("d/m/Y", strtotime($payment->date_paid));


                $teller = $person->first_name . " " . $person->last_name;

                $Output .= '<tr>

                        <td width="30">' . $count . '</td>

                        <td width="140">' . $tenant . '</td>

                        <td width="100">' . to_currency($apartment->apartment_amount, true, 0) . '</td>

                        <td width="100">' . to_currency($payment->amount, true, 0) . '</td>

                        <td width="100">' . to_currency($apartment_balance, true, 0) . '</td>

                        <td width="100">' . $trans_date . '</td>

                        <td width="100">' . $teller . '</td>

                        </tr>';

                $count++;
            }

            $data['payment_data'] = $Output;
        }

        $data['type'] = $type;

        $dompdf = new Dompdf();
        $html = view('reports/people_report', $data); // render the view into HTML
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // (Optional) Setup the paper size and orientation
        $dompdf->render();

        // $dompdf->Output($pdfFilePath, 'F'); // save to file because we can
        //end of pdf viewer
        //$data['pdf_file'] = FCPATH ."/downloads/reports/$filename.pdf";
        $data['pdf_file'] = "downloads/reports/$filename.pdf";


        echo view("reports/manage", $data);
    }
}
