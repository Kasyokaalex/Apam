<?php

namespace App\Models;

use CodeIgniter\Model;

class Report extends Model
{
    protected $table = 'report';
    protected $primaryKey = 'reportID';
    protected $DBGroup   = 'default';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'reportID ', 'report', 'reportType', 'reportDate', 'reportTime', 'reportBy', 'reportStatus', 'reportDescription', 'reportImage', 'reportLocation', 'reportDateCreated', 'reportDateUpdated', 'reportDateDeleted'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function generate_report()
    {
        $query = $this->select('apartmentName, description, apartmentStatus, housetypes, unitsCount, createdAt, updatedAt, deletedAt, apartmentID')
            ->findAll();
        $report = [];

        foreach ($query as $row) {
            $report[] = [
                'Apartment Name' => $row['apartmentName'],
                'Description' => $row['description'],
                'Apartment Status' => $row['apartmentStatus'],
                'House Types' => $row['housetypes'],
                'Units Count' => $row['unitsCount'],
                'Created At' => $row['createdAt'],
                'Updated At' => $row['updatedAt'],
                'Deleted At' => $row['deletedAt'],
                'Apartment ID' => $row['apartmentID'],
            ];
        }

        return $report;
    }
}
