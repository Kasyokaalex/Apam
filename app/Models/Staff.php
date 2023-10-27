<?php

namespace App\Models;

use CodeIgniter\Model;

class Staff extends Model {
    
    protected $table      = 'staff';
	protected $primaryKey = 'staffID';
	protected $returnType = 'object';

	protected $allowedFields = ['clientID', 'firstName', 'lastName', 'phone', 'email', 'photo', 'homeAddress', 'IDNumber','storeID', 'addedBy', 'role','token',  'username', 'password', 'systemUser'];

	protected $useTimestamps = true;
	protected $dateFormat = 'int';
    protected $useSoftDeletes = true;

	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = 'deletedAt';
    
    public function Authenticate($username = "", $password = "")
	{
		
		$builder = $this->builder();
		
		$builder->select('staffID')
				// ->where('systemUser', 1)
				->where('username', $username)
				->where("password", md5($password));
		
		return $builder->get()->getRowObject();
	}
    
    public function Exists($phoneNumber = "X")
	{
		
		$builder = $this->builder();
		
		$builder->select('staffID')->where('phoneNumber', $phoneNumber);
		
		return $builder->get()->getRowObject();
	}
    
}

?>
