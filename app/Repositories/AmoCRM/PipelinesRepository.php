<?php


namespace App\Repositories\AmoCRM;


use AmoCRM\Client\AmoCRMApiClient;

class PipelinesRepository
{
    public static function getArrayFromAmoCRM(AmoCRMApiClient $api_client)
    {
        $pipelines = $api_client->pipelines()->get();
        return $pipelines->toArray();
    }

    public static function getModelsFromAmoCRM(AmoCRMApiClient $api_client)
    {
        $pipelines = $api_client->pipelines()->get();
        return $pipelines;
    }

}