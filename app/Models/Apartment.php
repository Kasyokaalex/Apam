<?php

namespace App\Models;

use CodeIgniter\Model;

class Apartment extends Model
{
    protected $table = 'apartments';
    protected $primaryKey = 'apartmentID ';
    protected $DBGroup   = 'default';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'description', 'apartmentName','apartmentStatus', 'houseTypes', 'unitsCount', 'createdAt',
        'updatedAt', 'deletedAt'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';
    protected $deletedField  = 'deletedAt';




    
}
