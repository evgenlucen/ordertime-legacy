<?php


namespace App\Services\Analytics\FacebookAds\Tasks;


use App\Models\Dto\AmoCRM\LeadForAnalyticsDto;
use FacebookAds\Object\ServerSide\CustomData;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\UserData;


class CreateFacebookAdsEventTransactionByLeadForAnalyticsDto
{
    public static function run(LeadForAnalyticsDto $lead_dto, UserData $user_data)
    {
        $custom_data = (new CustomData())
            ->setCurrency('RUB')
            ->setValue($lead_dto->getRevenue());
        $transaction = (new Event())
            ->setEventName('Purchase')
            ->setEventTime(time())
            ->setOptOut(true)
            ->setUserData($user_data)
            ->setCustomData($custom_data);

        return $transaction;
    }

}