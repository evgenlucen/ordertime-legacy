<?php


namespace App\Services\Analytics\GoogleAnalytics;


use App\Models\AmoCRM\Status;

class GetStatusNameByStatusIdAndPipelineId
{
    /**
     * @param int $status_id
     * @param int $pipeline_id
     * @return string|null
     */
    public static function run(int $status_id,int $pipeline_id)
    {
        $result_collection = Status::select('name')
            ->where('status_id', '=',$status_id)
            ->where('pipeline_id',"=",$pipeline_id)
            ->get();

        if(!empty($result_collection)){
            return $result_collection->first()->name;
        } else {
            return null;
        }
    }

}