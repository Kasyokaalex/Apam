<?php
namespace App\Models;

use CodeIgniter\Model;
 
class Payment extends Model
{

	protected $table = "apartment_payments";
	protected $primaryKey = 'paymentID';
	protected $returnType = 'object';

	protected $allowedFields = ['apartment', 'tenant', 'amount', 'paymentMethod', 'breakdown'];

	protected $useTimestamps = true;
	protected $dateFormat = 'int';
    protected $useSoftDeletes = true;
	
	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = 'deletedAt';

}
