<?php


namespace App\Services\Analytics\FacebookAds\Tasks;


use App\Models\Dto\AmoCRM\LeadForAnalyticsDto;
use FacebookAds\Object\ServerSide\UserData;

class CreateFacebookAdsUserDtoByLeadFromAnalyticsDto
{
    public static function run(LeadForAnalyticsDto $lead_dto)
    {
        $user_data = (new UserData())
            ->setFbp($lead_dto->getFacebookClientId());

        return $user_data;
    }

}