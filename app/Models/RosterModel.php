<?php

namespace App\Models;

use CodeIgniter\Model;

class RosterModel extends Model
{
    protected $table            = 'rosters';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['small_business_entity_id', 'supervisory_authority_id', 'planned_verification_period_from', 'planned_verification_period_before', 'planned_duration_check'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [

        'small_business_entity_id' => [

            'rules' => 'required|numeric',
            'label' => 'СМП'
        ],
        'supervisory_authority_id' => [

            'rules' => 'required|numeric',
            'label' => 'контролирующий орган'
        ],
        'planned_verification_period_from' => [

            'rules' => 'required|valid_date',
            'label' => 'период проверки с'
        ],
        'planned_verification_period_before' => [

            'rules' => 'required|valid_date',
            'label' => 'период проверки по'
        ],
        'planned_duration_check' => [

            'rules' => 'required|numeric',
            'label' => 'длительность проверки'
        ],
    ];
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
}
