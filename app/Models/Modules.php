<?php

namespace App\Models;

use CodeIgniter\Model;

class Modules extends Model
{

	protected $table = "modules";
	protected $primaryKey = 'moduleID';
	protected $returnType = 'object';

	protected $allowedFields = ['controller', 'sort', 'icon', 'is_active', 'moduleID'];

	// protected $useTimestamps = true;
	// protected $dateFormat = 'int';
	// protected $useSoftDeletes = true;

	// protected $createdField  = 'created_at';
	// protected $updatedField  = 'updated_at';
	// protected $deletedField  = 'deleted_at';

}
