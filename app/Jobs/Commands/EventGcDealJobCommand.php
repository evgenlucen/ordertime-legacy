<?php

namespace App\Jobs\Commands;

use AmoCRM\Client\AmoCRMApiClient;
use App\Models\Dto\Action\ActionParamsDto;
use App\Models\Dto\GetCourse\DealDto;

class EventGcDealJobCommand implements \JsonSerializable
{
    public string $eventName;

    public AmoCRMApiClient $apiClient;

    public DealDto $dealDto;

    public ActionParamsDto $actionParam;

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}
