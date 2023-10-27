<?php

namespace App\Models;

use CodeIgniter\Model;

class Preference extends Model {
    
    protected $table      = 'preferences';
	protected $primaryKey = 'prefID';
	protected $returnType = 'object';

	protected $allowedFields = ['short_hand, description, title'];

	protected $useTimestamps = false;

}

?>
