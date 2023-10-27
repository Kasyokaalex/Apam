<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentMethod extends Model {
    
    protected $table      = 'payment_methods';
	protected $primaryKey = 'methodID';
	protected $returnType = 'object';

protected $allowedFields = ['name', 'description', 'icon', 'addedBy'];

	protected $useTimestamps = true;
	protected $dateFormat = 'int';
    protected $useSoftDeletes = true;

	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = 'deletedAt';
    
}

?>
