<?php

namespace Tests\Jobs;

use App\Jobs\Commands\EventGcDealJobCommand;
use App\Jobs\EventGcDealJob;
use App\Models\Dto\Action\ActionParamsDto;
use App\Models\Dto\Action\AmoActionDto;
use App\Models\Dto\GetCourse\DealDto;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use PHPUnit\Framework\TestCase;

class EventGcDealJobTest extends TestCase
{
    public function test_successful()
    {
        $command = new EventGcDealJobCommand();

        $deal = new DealDto();
        $deal->setName('Test');
        $deal->setId(123123);
        $deal->setNumber(321321);
        $deal->setPositions("POSTIONS");

        $eventName = 'deal_create';

        $command->dealDto = $deal;
        $command->eventName = $eventName;

        $actionParams = new ActionParamsDto();
        $actionParams->setName('deal_create');
        $amoAction = new AmoActionDto();
        $amoAction->setStatusId(321321);
        $amoAction->setPipelineId(123123);
        $actionParams->setAmocrmAction($amoAction);
        $command->actionParam = $actionParams;

        $command->apiClient = GetApiClient::getApiClient();


        dd(EventGcDealJob::dispatch($command));


    }
}
