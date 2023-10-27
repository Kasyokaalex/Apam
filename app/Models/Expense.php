<?php

namespace App\Models;

use CodeIgniter\Model;

class Expense extends Model {
    
    protected $table      = 'expenses';
	protected $primaryKey = 'expenseID';
	protected $returnType = 'object';

	protected $allowedFields = ['name', 'category', 'description', 'amount', 'addedBy','date','storeID', 'supplier'];

	protected $useTimestamps = true;
	protected $dateFormat = 'int';
    protected $useSoftDeletes = true;

	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = 'deletedAt';

}

?>
