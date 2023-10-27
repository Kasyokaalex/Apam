<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseCategory extends Model {
    
    protected $table      = 'expense_categories';
	protected $primaryKey = 'categoryID';
	protected $returnType = 'object';

	protected $allowedFields = ['name', 'departmentID', 'addedBy'];

	protected $useTimestamps = true;
	protected $dateFormat = 'int';
    protected $useSoftDeletes = true;

	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = 'deletedAt';

}

?>
