<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RosterModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class ApiSearch extends BaseController
{
    use ResponseTrait;
    private $rosterModel;
    public function __construct()
    {
        $this->rosterModel = new RosterModel();
    }
    public function filterRoster()
    {
        extract($this->request->getGet());

        $query = $this->rosterModel
        ->select('rosters.id, small_business_entities.title AS SBE_title, rosters.planned_verification_period_from, rosters.planned_verification_period_before, rosters.planned_duration_check, supervisory_authorities.title AS SA_title')
        ->join('supervisory_authorities', 'rosters.supervisory_authority_id = supervisory_authorities.id', 'left')
        ->join('small_business_entities', 'rosters.small_business_entity_id = small_business_entities.id', 'left');
        
        if (!empty($smallBusinessEntityId)) {
            
            $query->where('rosters.small_business_entity_id', $smallBusinessEntityId);
        }

        if (!empty($from)) {
            
            $query->where('rosters.planned_verification_period_from', $from);
        }

        if (!empty($before)) {
            
            $query->where('rosters.planned_verification_period_before', $before);
        }

        if (!empty($supervisoryAuthorityId)) {
            
            $query->where('rosters.supervisory_authority_id', $supervisoryAuthorityId);
        }

        if (!empty($plannedDurationCheck)) {
            
            $query->where('rosters.planned_duration_check', $plannedDurationCheck);
        }
        
        $rosters = $query->find();

        return $this->respond($rosters);
    }
}
