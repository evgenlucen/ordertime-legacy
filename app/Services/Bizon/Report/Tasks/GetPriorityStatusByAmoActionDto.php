<?php


namespace App\Services\Bizon\Report\Tasks;


use App\Models\AmoCRM\Status;
use App\Models\Dto\Action\AmoActionDto;

class GetPriorityStatusByAmoActionDto
{
    public static function run(AmoActionDto $actionDto)
    {
        $result = Status::select('id')
            ->where('status_id','=',$actionDto->getStatusId())
            ->where('pipeline_id', '=', $actionDto->getPipelineId())
            ->get();

        if(!empty($result->first())){
            return $result->first()->id;
        } else {
            return null;
        }
    }

}