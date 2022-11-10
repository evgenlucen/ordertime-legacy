<?php


namespace App\Services\AmoCRM\Pipelines\Statuses;


use AmoCRM\Client\AmoCRMApiClient;
use App\Models\AmoCRM\Status;
use Illuminate\Support\Facades\DB;

class AddStatusesDataToDataBase
{
    public static function run(AmoCRMApiClient $api_client)
    {
        $pipelines = $api_client->pipelines()->get();
        $result = [];
        foreach ($pipelines as $pipeline) {
            $statuses = $pipeline->getStatuses();

            foreach ($statuses as $status) {
                $status_model = new Status();
                $status_model->status_id = $status->getId();
                $status_model->pipeline_id = $pipeline->getId();
                $status_model->name = $status->getName();
                $status_model->color = $status->getColor();
                $status_model->type = $status->getType();
                $result[] = DB::table('statuses')->update($status_model->toArray());
                //$result[] = $status_model['name'] . " - " . (string)$status_model->updateOrCreate(['status_id' => $status->getId()], $status_model->toArray());
            }
        }
        return $result;
    }

}