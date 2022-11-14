<?php

namespace App\Services\Analytics\GA4;

use App\Models\Dto\AmoCRM\LeadForAnalyticsDto;
use Br33f\Ga4\MeasurementProtocol\Dto\Common\EventCollection;
use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserProperties;
use Br33f\Ga4\MeasurementProtocol\Dto\Common\UserProperty;
use Br33f\Ga4\MeasurementProtocol\Dto\Event\BaseEvent;
use Br33f\Ga4\MeasurementProtocol\Dto\Parameter\BaseParameter;
use Br33f\Ga4\MeasurementProtocol\Dto\Request\BaseRequest;

class CreateGA4EventByLeadForAnalyticsDto
{
    public const CHANGE_LEAD_STATUS = 'change_lead_status';
    public const PARAM_STATUS_NAME  = 'status_name';
    public const PARAM_CRM_NAME  = 'crm_name';
    public const PARAM_STATUS_ID = 'status_id';
    public const USER_CURRENT_CRM_STATUS = 'current_crm_status';


    public static function run(LeadForAnalyticsDto $leadForAnalyticsDto): BaseRequest
    {

        $eventsCollection = new EventCollection();

        $event = new BaseEvent(self::CHANGE_LEAD_STATUS);
        $event->addParam(self::PARAM_CRM_NAME, new BaseParameter($leadForAnalyticsDto::CRM_NAME));
        $event->addParam(self::PARAM_STATUS_NAME, new BaseParameter($leadForAnalyticsDto->getStatusName()));
        $event->addParam(self::PARAM_STATUS_ID, new BaseParameter($leadForAnalyticsDto->getStatusId()));

        $baseRequest = new BaseRequest($leadForAnalyticsDto->getGoogleClientId(),$eventsCollection);

        $userPropertiesCollection = new UserProperties();
        $userPropertiesCollection->addUserProperty(
            new UserProperty(self::USER_CURRENT_CRM_STATUS, $leadForAnalyticsDto->getStatusName())
        );

        $baseRequest->setUserProperties($userPropertiesCollection);

        return $baseRequest;
    }

}
