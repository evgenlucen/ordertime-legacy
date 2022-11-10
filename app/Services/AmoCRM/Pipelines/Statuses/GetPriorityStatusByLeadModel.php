<?php


namespace App\Services\AmoCRM\Pipelines\Statuses;


use AmoCRM\Models\LeadModel;
use App\Models\AmoCRM\Status;

class GetPriorityStatusByLeadModel
{
    /**
     * @param LeadModel $lead
     * @return mixed
     */
    public static function run(LeadModel $lead)
    {
        $result = Status::select('id')
            ->where('status_id','=',$lead->getStatusId())
            ->where('pipeline_id', '=', $lead->getPipelineId())
            ->get();
        if(!empty($result)){
            return $result->first()->id;
        } else {
            return null;
        }
    }

}