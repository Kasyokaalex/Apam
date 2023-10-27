<?php

namespace App\Models;

use CodeIgniter\Model;

class Letter extends Model
{
    protected $table = 'letters';
    protected $primaryKey = 'letterID';
    protected $DBGroup   = 'default';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'letterID', 'address', 'subject', 'createdBy', 'message', 'dateCreated', 'deleteFlag'
    ];
}
