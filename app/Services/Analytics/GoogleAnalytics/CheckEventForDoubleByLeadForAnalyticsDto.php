<?php


namespace App\Services\Analytics\GoogleAnalytics;


use App\Models\AmoCRM\LeadEvent;
use App\Models\Dto\AmoCRM\LeadForAnalyticsDto;

class CheckEventForDoubleByLeadForAnalyticsDto
{
    /**
     * @param LeadForAnalyticsDto $lead_dto
     * @return \Illuminate\Support\Collection
     */
    public static function run(LeadForAnalyticsDto $lead_dto)
    {
        return LeadEvent::where("lead_id","=",$lead_dto->getLeadId())
            ->where("event_name","=",$lead_dto->getStatusName())
            ->get();
    }

}