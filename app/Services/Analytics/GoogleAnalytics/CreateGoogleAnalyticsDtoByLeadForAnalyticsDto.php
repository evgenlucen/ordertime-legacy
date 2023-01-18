<?php


namespace App\Services\Analytics\GoogleAnalytics;


use App\Configs\googleAnalyticsConfig;
use App\Models\Dto\AmoCRM\LeadForAnalyticsDto;
use App\Services\Analytics\GoogleAnalytics\Tasks\AddTransactionToAnalyticsDto;
use App\Services\Analytics\GoogleAnalytics\Tasks\AddUtmToAnalyticsDto;
use App\Configs\amocrmConfig;
use TheIconic\Tracking\GoogleAnalytics\Analytics;

class CreateGoogleAnalyticsDtoByLeadForAnalyticsDto
{
    /**
     * @param LeadForAnalyticsDto $lead_dto
     * @return Analytics
     */
    public static function run(LeadForAnalyticsDto $lead_dto)
    {
        $analytics = new Analytics(false);

        $analytics
            ->setProtocolVersion('1')
            ->setTrackingId(env('UA'))
            ->setClientId($lead_dto->getGoogleClientId());

        if ($lead_dto->isIsGaCidGenerated() === TRUE) {
            $analytics = AddUtmToAnalyticsDto::run($analytics,$lead_dto);
        }

        $analytics->setEventCategory(googleAnalyticsConfig::EVENT_CATEGORY_AMOCRM);
        $analytics->setEventAction($lead_dto->getStatusName());
        $analytics->setEventValue($lead_dto->getRevenue());

        if ($lead_dto->getStatusId() == amocrmConfig::STATUS_PAYMENT_SUCCESS) {
            $analytics = AddTransactionToAnalyticsDto::run($analytics,$lead_dto);
        }

        return $analytics;
    }

}
