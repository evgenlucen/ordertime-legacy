<?php


namespace App\Services\AmoCRM\Pipelines\Tasks;


use App\Configs\amocrmConfig;

class CheckPipelineAccessForAnalytics
{

    public static function run(int $pipeline_id)
    {
        if (array_search($pipeline_id, amocrmConfig::PIPELINES_ID_FOR_UA) === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}