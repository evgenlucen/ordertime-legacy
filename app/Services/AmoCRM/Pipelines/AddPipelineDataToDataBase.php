<?php


namespace App\Services\AmoCRM\Pipelines;


use AmoCRM\Client\AmoCRMApiClient;
use App\Models\AmoCRM\Pipeline;

class AddPipelineDataToDataBase
{
    public static function run(AmoCRMApiClient $api_client)
    {
        $pipelines = $api_client->pipelines()->get();
        $result = [];
        foreach ($pipelines as $pipeline) {
            $pipeline_model = new Pipeline();
            $pipeline_model->id = $pipeline->getId();
            $pipeline_model->name = $pipeline->getName();
            $pipeline_model->is_main = $pipeline->getIsMain();
            $result[] = $pipeline_model['name'] . " - " . (string)$pipeline_model->updateOrCreate(['id' => $pipeline->getId()], $pipeline_model->toArray());
        }
        return $result;
    }

}