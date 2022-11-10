<?php


namespace App\Services\Analytics\GoogleAnalytics\Tasks;


use App\Models\Dto\AmoCRM\LeadForAnalyticsDto;
use TheIconic\Tracking\GoogleAnalytics\Analytics;

class AddUtmToAnalyticsDto
{

    public static function run(Analytics $analytics,LeadForAnalyticsDto $lead_dto)
    {
        if (!empty($lead_dto->getUtmSource())) {
            $analytics->setCampaignSource($lead_dto->getUtmSource());
        }
        if (!empty($lead_dto->getUtmMedium())) {
            $analytics->setCampaignMedium($lead_dto->getUtmMedium());
        }
        if (!empty($lead_dto->getUtmCampaign())) {
            $analytics->setCampaignName($lead_dto->getUtmCampaign());
        }
        if (!empty($lead_dto->getUtmTerm())) {
            $analytics->setCampaignKeyword($lead_dto->getUtmTerm());
        }
        if (!empty($lead_dto->getUtmContent())) {
            $analytics->setCampaignContent($lead_dto->getUtmContent());
        }

        return $analytics;
    }
}