<?php

namespace App\Http\Controllers\Analytics;

use App\Configs\googleAnalyticsConfig;
use App\Http\Controllers\Controller;
use App\Services\Analytics\GoogleAnalytics\Tasks\CreateGeneratedGaCid;
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

        Assert::notEmpty($event_name,"Undefined event_name");

        $event_params = $request->input('event_params') ?? null;
        $user_params = $request->input('user_params') ?? null;
        $ga_client_id = $request->input('ga_client_id') ?? null;


        if(null === $ga_client_id){
            $ga_client_id = CreateGeneratedGaCid::run();
        }


        $request_to_ga = new BaseRequest($ga_client_id);

        /** Event */
        $event = new BaseEvent($event_name);

        if(null !== $event_params){
            foreach ($event_params as $name => $value){
                $event->addParam($name, new BaseParameter($value));
            }
        }

        $request_to_ga->addEvent($event);

        /** User Params */
        if(null !== $user_params) {
            $userProperties = new UserProperties();
            foreach ($user_params as $name => $value){
                $userProperties->addUserProperty(
                    new UserProperty($name, $value)
                );
            }
            $request_to_ga->setUserProperties($userProperties);
        }


        $sendService = new Service(googleAnalyticsConfig::getApiKey(), googleAnalyticsConfig::getStreamId());
        $result_send_response = $sendService->send($request_to_ga);

        return new JsonResponse(
            [
                'success' => true,
                'data' => [
                    'code' => $result_send_response->getStatusCode(),
                    'body' => $result_send_response->getBody(),
                    'data' => $result_send_response->getData(),
                    'ga_cid' => $ga_client_id
                    #'message' => $result_send_response->getValidationMessages()
                ]
            ]
        );
    }
}
