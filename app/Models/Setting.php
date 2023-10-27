<?php
namespace App\Models;

use CodeIgniter\Model;

class Setting extends Model {

    protected $table = "settings";
	protected $primaryKey = 'key';
	protected $returnType = 'object';

	protected $allowedFields = ['value'];
    protected $useSoftDeletes = false;

    public static function apamSettings()
    {
        
        $items = [];
        
        foreach ((new self)->findAll() as $item) {
            
            $items[$item->key] = $item->value;
        }
             
        return $items;
    }
    

    public static function loggedInStaff()
    {
        
        $session = \Config\Services::session();
        $staffModel = new Staff();
        
		$userID = $session->get('apam_staff_id');
        if($userID > 0){
            
            $userData = $staffModel->select('staff.*')
                    ->where('staff.staffID', $userID)
                ->first();
                
            if($userData != null) $userData->password = "Gotcha!";
            
        }else{
            $userData = ['subscription'=>null];
        }
        return (array) $userData;
    }


    function get_notifications()
    {
        $result = [];

        return $result;
    }

}

?>