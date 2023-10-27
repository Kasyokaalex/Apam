<?php

namespace App\Models;

use CodeIgniter\Model;

class Tenant extends Model
{

    protected $table = 'tenants';
    protected $primaryKey = 'tenantID ';

    protected $returnType    = 'object';
    protected $allowedFields = [
        'tenantID ', 'firstName', 'lastName', 'IDNumber', 'homeAddress', 'phoneNumber',
        'roomNumber', 'emailAddress', 'gender', 'occupation', 'addedBy', 'createdAt', 'updatedAt', 'deletedAt'
    ];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';
    protected $deletedField  = 'deletedAt';
}
