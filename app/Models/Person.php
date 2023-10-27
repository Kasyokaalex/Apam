<?php

namespace App\Models;

use CodeIgniter\Model;

class Person extends Model
{
    protected $table = 'people';
    protected $primaryKey = 'personID ';
    protected $DBGroup   = 'default';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'personID ', 'firstName', 'lastName', 'photoUrl', 'idNumber', 'homeAddress', 'phoneNumber', 'email', 'phoneNumber', 'homeAddress', 'employer'
    ];
}
