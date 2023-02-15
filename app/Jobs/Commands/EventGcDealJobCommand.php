<?php

namespace App\Jobs\Commands;

use AmoCRM\Client\AmoCRMApiClient;
use App\Configs\amocrmConfig;
use App\Models\Dto\Action\ActionParamsDto;
use App\Models\Dto\GetCourse\DealDto;

class EventGcDealJobCommand
{
    public string $eventName;

    public AmoCRMApiClient $apiClient;

    public DealDto $dealDto;

    public ActionParamsDto $actionParam;

}
