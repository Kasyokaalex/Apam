<?php

namespace App\Controllers;

use App\Libraries\Uploader;
use App\Models\Country;
use App\Models\Department;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use App\Models\Preference;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\Store;
use App\Models\Tax;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\View;
use Psr\Log\LoggerInterface;

class Settings extends BaseController {

    protected $_staffModel, $_personModel, $_customerModel, $_saleModel, $_settingsModel, $_paymentMethodModel, $_taxModel, $_countryModel, $_storeModel, $_departmentModel, $_prefModel;
    protected $_session, $_userID, $_userData;
    
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
        
		$this->_staffModel = new Staff(); 
        $this->_settingsModel = new Setting();
        $this->_paymentMethodModel = new PaymentMethod();
        $this->_countryModel = new Country();
        $this->_prefModel = new Preference();
        $this->_session = \Config\Services::session();
        		
	}
    

    function index()
    {
        helper('download', 'file');
        
        $data['controller_name'] = "System settings";
        $data['countries'] = $this->_countryModel->select('code, name')->findAll();
        $data['currencies'] = $this->_countryModel->select('currency, code, name as country')->findAll();
        $data['preferences'] = $this->_prefModel->findAll();
        $data['departments'] = [];

        //$data["smtp_info"] = $this->Email->get_smtp_info();
        echo View("settings", $data);
    }

    function save()
    {
        $data = array(
            [
                'key' => "company",
                'value' => $this->request->getPost('company')
            ],
            [
                'key' => 'address',
                'value' => $this->request->getPost('address')
            ],
            [
                'key' => 'phone',
                'value' => $this->request->getPost('phone')
            ],
            [
                'key' => 'email',
                'value' => $this->request->getPost('email')
            ],
            [
                'key' => 'website',
                'value' => $this->request->getPost('website')
            ],
            [
                'key' => 'currency_symbol',
                'value' => $this->request->getPost('currency_symbol')
            ],
            [
                'key' => 'currency_side',
                'value' => "0"
            ],
            [
                'key' => 'language',
                'value' => $this->request->getPost('language')
            ],
            [
                'key' => 'timezone',
                'value' => $this->request->getPost('timezone')
            ]
        );

        // var_dump($data);
        
        $smtp_data = [            
            "smtp_id" => $this->request->getPost("smtp_id"),
            "smtp_host" => $this->request->getPost("smtp_host"),
            "smtp_port" => $this->request->getPost("smtp_port"),
            "smtp_user" => $this->request->getPost("smtp_user"),
            "smtp_pass" => $this->request->getPost("smtp_pass"),
        ];

        if ($this->_settingsModel->updateBatch($data, 'key'))
        {
            // saving SMTP settings             
            // $this->Email->save_smtp($smtp_data);
            echo json_encode(array('success' => true, 'message' => 'Configurations saved successfully'));
        }else{
            echo json_encode(array('success' => false, 'message' => 'Updates Failed', 'details' => json_encode($this->_settingsModel->errors())));
        }

    }

    public function savePaymentMethod()
    {
        $paymentData = [
            'name' => $this->request->getPost("name"),
            'description' => $this->request->getPost("description"),
            'icon' => $this->request->getPost("icon"),
            'addedBy' => config('loggedInStaff')->staffID
        ];

        if($this->request->getPost("methodID") != "") $paymentData['methodID'] = $methodID = $this->request->getPost("methodID");
         
        if ($this->_paymentMethodModel->save($paymentData))
        {
            echo json_encode(array('success' => true, 'message' => 'Payment Methods Updated successfully'));
        }
        else//failure
        {
            echo json_encode(array('success' => false, 'message' => 'Error while updating Payment method!', 'methodID' => -1, 'details' => $this->_paymentMethodModel->errors()));
        }

    }

    public function paymentMethods()
    {
        $methods = $this->getPaymentMethods();

        $format_result = [];

        foreach ($methods as $method)
        {            
            $format_result[] = array(
                $method->methodID,
                "<span style ='font-size: 18px; position: absolute; margin-top: -22px; color: #800080' class='".$method->icon."'><span>",
                $method->name,
                $method->description
            );
        }

        echo json_encode($format_result);
    }

    public function getPaymentMethod($paymentMethodID = 0)
    {
        $method = (new PaymentMethod())->find($paymentMethodID);

        echo json_encode($method);
    }
    

    public function getPaymentMethods()
    {
        $methods = (new PaymentMethod())->
                select('payment_methods.*, CONCAT(staff.firstName," ",staff.lastName) as staffName', FALSE)->
                join('staff', "staff.staffID = payment_methods.addedBy")->
            findAll();

        return $methods;
    }
    
    /*
      This deletes payment method
     */

    function deletePaymentMethod()
    {
        $paymentMethodsToDelete = $this->request->getPost('ids');

        if ($this->_paymentMethodModel->delete($paymentMethodsToDelete))
        {
            echo json_encode(array('success' => true, 'message' => "Method successfully deleted !"));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => "Method cannot be deleted"));
        }
    }
    
    public function saveStore()
    {
        $storeData = [
            'storeName' => $this->request->getPost("storeName"),
            'physicalLocation' => $this->request->getPost("store-location"),
            'phone' => $this->request->getPost("store-phone"),
            'email' => $this->request->getPost("store-email"),
            'countryID' => $this->request->getPost("countryID"),
            'addedBy' => $this->_session->get('staffID')
        ];

        if($this->request->getPost("storeID") != "") $storeData['storeID'] = $storeID = $this->request->getPost("storeID");
         
        if ($this->_storeModel->save($storeData))
        {
            //New customer
            if ($storeID == "")
            {
                $storeID = $this->_storeModel->where('storeName', $storeData['storeName'])->where('physicalLocation', $storeData['physicalLocation'])->first()->storeID;

                echo json_encode(array('success' => true, 'message' => 'Store added successfully', 'storeID' => $storeID));
            }
            else //previous Store
            {
                echo json_encode(array('success' => true, 'message' => 'Store updated successfully', 'storeID' => $storeID));
            }
        }
        else//failure
        {
            echo json_encode(array('success' => false, 'message' => 'Error while updating Store!', 'storeID' => -1));
        }
    }
    
    public function getStores()
    {
        $stores = $this->_storeModel->
                select('stores.*, CONCAT(staff.firstName," ",staff.lastName) as staffName', FALSE)->
                join('staff', "staff.staffID = stores.addedBy")->
            findAll();
            
        $format_result = [];

        foreach ($stores as $store)
        {            
            $format_result[] = array(
                $store->storeID,
                $store->storeName,
                $store->physicalLocation,
                $store->phone,
                date('d M, Y', $store->createdAt),
            );
        }

        echo json_encode($format_result);
    }
    
    public function getStore($storeID = 0)
    {
        $store = $this->_storeModel->find($storeID);

        echo json_encode($store);
    }
    
    
    function deleteStore()
    {
        $storesToDelete = $this->request->getPost('ids');

        if ($this->_storeModel->delete($storesToDelete))
        {
            echo json_encode(array('success' => true, 'message' => "Store successfully deleted !"));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => "Store cannot be deleted"));
        }
    }
    
    

    public function saveTax()
    {
        $taxData = [
            'name' => $this->request->getPost("name"),
            'inclusive' => $this->request->getPost("tax-mode"),
            'percentage' => $this->request->getPost("percentage"),
            'description' => $this->request->getPost("description"),
            'addedBy' => $this->_session->get('staffID')
        ];
        
        ($this->request->getPost("taxID") != "") ? $taxData['taxID'] = $this->request->getPost("taxID") : "";
 
        if ($this->_taxModel->save($taxData))
        {
            //New customer
            if ($taxData['taxID'] == "")
            {
                $taxID = $this->_taxModel->where('name', $taxData['name'])->where('description', $taxData['description'])->first()->taxID;

                echo json_encode(array('success' => true, 'message' => 'Tax added successfully', 'taxID' => $taxID));
            }
            else //previous Payment method
            {
                echo json_encode(array('success' => true, 'message' => 'Tax updated successfully', 'taxID' => $taxData['taxID']));
            }
        }
        else//failure
        {
            echo json_encode(array('success' => false, 'message' => 'Error while updating Tax!', 'taxID' => -1));
        }

    }

    public function taxes()
    {
        $taxes = $this->getTaxes();

        $format_result = [];

        foreach ($taxes as $tax)
        {            
            $format_result[] = array(
                $tax->taxID,
                $tax->name,
                $tax->percentage . "%",
                $tax->description
            );
        }

        echo json_encode($format_result);
    }

    public function getTax($taxID = 0)
    {
        $method = (new tax())->find($taxID);

        echo json_encode($method);
    }
    

    public function getTaxes()
    {
        $methods = (new Tax())->
                select('taxes.*, CONCAT(staff.firstName," ",staff.lastName) as staffName', FALSE)->
                join('staff', "staff.staffID = taxes.addedBy")->
            findAll();

        return $methods;
    }    
    
    /*
      This deletes payment method
     */

    function deleteTax()
    {
        $taxsToDelete = $this->request->getPost('ids');

        if ($this->_taxModel->delete($taxsToDelete))
        {
            echo json_encode(array('success' => true, 'message' => "Method successfully deleted !"));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => "Method cannot be deleted"));
        }
    }

  

    


    
    function upload()
    {
        $directory = FCPATH."/public/uploads/logo";
        
        if(!is_dir($directory)){ // CREATE THE DIRECTORY IF IT DOESN'T EXIST
            mkdir($directory, 0777, true);
        }
        
        $uploader = new Uploader();
        
        $data = $uploader->upload($directory);
        
        $settingsData = array(
            "key" => "logo", 
            "value" => $data['filename']
        );

        $this->_settingsModel->save($settingsData);
        $data['company_name'] = strtolower(preg_replace('/\s+/', '', Config("apamSettings")->company));

        echo json_encode($data);
        exit;
    }

    function backup()
    {
        // $this->load->dbutil();

        // $format = array('format' => 'zip', 'file_name' => 'jk_db_backup.sql;');

        // $backup = & $this->dbutil->backup($format); 

        // $db_name = "jk_".date('dmYhi').".zip";

        // $save = "downloads/".$db_name;

        // if(write_file($save, $backup)){

        //     $str = file_get_contents("backup_logs.json", true);

        //     $logs = json_decode($str);

        //     $file_dits = array('name' => $db_name , 'time_stamp' => time(), "backup_by" => $this->session->userdata('person_id'));

        //     array_push($logs, $file_dits);

        //     $new_logs = json_encode($logs);

        //     file_put_contents("backup_logs.json", $new_logs);

        //     force_download($db_name, $backup);

        // }
    }
    
    function xprd($expiryTime) {
        
        // if here and subscription is not expired, redirect to dashboard
        if(config('loggedInStaff')->subscription->expiryDate > time()) {
            return redirect()->to(base_url('home'));
        }
        
        return View("expiry", ["expiryTime" => $expiryTime]);
    }
    
    function updatePrefs() {
        $incomingPref = $this->request->getPost('pref');
        $incomingPrefValue = $this->request->getPost('prefValue');
        
        if(intval($incomingPref) == 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid Preference']);
            exit();
        }
        
        $prefs = json_decode(config('apamSettings')->preferences);
        $prefSize = count($prefs);
        
        if($incomingPrefValue == "1" && !in_array($incomingPref, $prefs)){
            array_push($prefs, $incomingPref);
        }
        
        if($incomingPrefValue == "0" && in_array($incomingPref, $prefs)){
            array_splice($prefs, array_search($incomingPref, $prefs), 1);
        }
                
        if($prefSize != sizeof($prefs) && $this->_settingsModel->save(['key' => 'preferences', 'value' => json_encode($prefs)])){
            echo json_encode(['success' => true, 'message' => 'Preferences updated successfully']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Preference update failed']);
        }
    }

}

?>