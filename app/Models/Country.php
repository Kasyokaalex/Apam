<?php

namespace App\Models;

use CodeIgniter\Model;

class Country extends Model {
    
    protected $table      = 'countries';
	protected $primaryKey = 'code';
	protected $returnType = 'object';

	protected $allowedFields = ['name, native, phone, continent, capital, currency, languages'];

	protected $useTimestamps = false;

}

?>
