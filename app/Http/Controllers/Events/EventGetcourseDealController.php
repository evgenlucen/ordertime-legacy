<?php

namespace App\Http\Controllers\Events;


use App\Configs\eventsConfig;
use App\Jobs\EventGcDealJob;
use App\Models\Dto\GetCourse\DealDto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class EventGetcourseDealController extends Controller
{
    /**
     * @throws \Exception
     */
    public static function run(Request $request): JsonResponse
    {

        if (empty($request->event_name)) {
            throw new \InvalidArgumentException(sprintf("Undefined event_name in request %s", json_encode($request->toArray(),true) ));
        }

        $resultDispatch = EventGcDealJob::dispatch(
            $request->event_name,
            DealDto::fromRequest($request),
            eventsConfig::getActionParamsDtoByEventName($request->event_name)
        );

        return new JsonResponse(['success' => true, 'data' =>
            [
                'in_queue' => true
            ]]);
    }
}
