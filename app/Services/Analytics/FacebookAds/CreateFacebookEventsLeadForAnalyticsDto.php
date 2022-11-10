<?php


namespace App\Services\Analytics\FacebookAds;


use App\Models\Dto\AmoCRM\LeadForAnalyticsDto;
use App\Models\Dto\Facebook\FacebookAdsDto;
use App\Services\Analytics\FacebookAds\Tasks\CreateFacebookAdsEventTransactionByLeadForAnalyticsDto;
use App\Services\Analytics\FacebookAds\Tasks\CreateFacebookAdsUserDtoByLeadFromAnalyticsDto;
use App\Configs\amocrmConfig;
use FacebookAds\Object\ServerSide\Event;

class CreateFacebookEventsLeadForAnalyticsDto
{
    public static function run(FacebookAdsDto $fb_dto, LeadForAnalyticsDto $lead_dto)
    {

        $user_data = CreateFacebookAdsUserDtoByLeadFromAnalyticsDto::run($lead_dto);

        $event = (new Event())
            ->setEventName($lead_dto->getStatusName())
            ->setEventTime(time())
            ->setOptOut(true)
            ->setEventSourceUrl($fb_dto->getDomain())
            ->setActionSource('other')
            ->setUserData($user_data);

        $events = array();
        array_push($events, $event);

        if($lead_dto->getStatusId() == amocrmConfig::STATUS_PAID_SUCCESS){
            $transaction = CreateFacebookAdsEventTransactionByLeadForAnalyticsDto::run($lead_dto,$user_data);
            array_push($events, $transaction);
        }

        return $events;
    }

}