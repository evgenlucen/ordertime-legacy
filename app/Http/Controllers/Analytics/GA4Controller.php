<?php

namespace App\Http\Controllers\Analytics;

use App\Configs\googleAnalyticsConfig;
use App\Http\Controllers\Controller;
use Br33f\Ga4\MeasurementProtocol\Dto\Common\EventCollection;
use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserProperties;
use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserProperty;
use Br33f\Ga4\MeasurementProtocol\Dto\Event\BaseEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\BaseParameter;
use Br33f\Ga4\MeasurementProtocol\Dto\Request\BaseRequest;
use Br33f\Ga4\MeasurementProtocol\Exception\HydrationException;
use Br33f\Ga4\MeasurementProtocol\Exception\ValidationException;
use Br33f\Ga4\MeasurementProtocol\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webmozart\Assert\Assert;

class GA4Controller extends Controller
{
    /**
     * @throws HydrationException
     * @throws ValidationException
     */
    public function run(Request $request): JsonResponse
    {
        $event_name = $request->input('event_name') ?? null;

        Assert::notEmpty($event_name);

        $event_params = $request->input('event_params') ?? null;
        $user_params = $request->input('user_params') ?? null;
        $ga_client_id = $request->input('ga_client_id') ?? null;


        $request = new BaseRequest();

        /** Event */
        $event = new BaseEvent($event_name);

        if(null !== $event_params){
            foreach ($event_params as $event_param){
                $event->addParam($event_param['name'], new BaseParameter($event_param['value']));
            }
        }

        $request->addEvent($event);

        /** User Params */
        if(null !== $user_params) {
            $userProperties = new UserProperties();
            foreach ($user_params as $user_param){
                $userProperties->addUserProperty(
                    new UserProperty($user_param['name'], $user_param['value'])
                );
            }
        }


        $sendService = new Service(googleAnalyticsConfig::getApiKey(), googleAnalyticsConfig::getStreamId());
        $result_send_response = $sendService->send($request);

        return new JsonResponse(['success' => true, 'data' => [$result_send_response->getData()]]);
    }
}
