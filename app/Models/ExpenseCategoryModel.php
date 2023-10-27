<?php

namespace App\Models;

use CodeIgniter\Model;

class Expense extends Model
{
    protected $table = 'expenses_categories';
    protected $primaryKey = 'expenseID';
    protected $DBGroup   = 'default';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['category', 'description', 'amount', 'addedBy', 'date'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';
    protected $deletedField  = 'deletedAt';
}
