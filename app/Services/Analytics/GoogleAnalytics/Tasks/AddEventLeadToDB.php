<?php


namespace App\Services\Analytics\GoogleAnalytics\Tasks;


use App\Models\AmoCRM\LeadEvent;
use App\Models\Dto\AmoCRM\LeadForAnalyticsDto;

class AddEventLeadToDB
{
    public static function run(LeadForAnalyticsDto $lead_dto)
    {
        return LeadEvent::create(['lead_id' => $lead_dto->getLeadId(),'event_name'=> $lead_dto->getStatusName()]);
    }

}