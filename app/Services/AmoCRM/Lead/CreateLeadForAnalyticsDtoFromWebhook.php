<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use App\Models\Dto\AmoCRM\LeadForAnalyticsDto;
use App\Services\AmoCRM\Interfaces\WebhookTypeInterface;
use App\Services\AmoCRM\Lead\Tasks\GetLeadArrayByWebhook;
use App\Services\AmoCRM\Lead\Tasks\GetLeadIdByWebhook;
use App\Services\AmoCRM\Lead\Tasks\GetTypeEventByWebhook;
use Illuminate\Http\Request;

class CreateLeadForAnalyticsDtoFromWebhook
{
    /**
     * Создать LeadDto по хуку из Амо
     * @param Request $request
     * @param AmoCRMApiClient $api_client
     * @return LeadForAnalyticsDto
     * @throws \AmoCRM\Exceptions\AmoCRMApiException
     * @throws \AmoCRM\Exceptions\AmoCRMMissedTokenException
     * @throws \AmoCRM\Exceptions\AmoCRMoAuthApiException
     */
    public static function run(Request $request,AmoCRMApiClient $api_client)
    {
        $lead_for_analytics_dto = new LeadForAnalyticsDto();

        # узнать тип вебхука
        $webhook_type = GetTypeEventByWebhook::run($request);

        # Если в массиве есть все что нужно - работаем с ним
        if($webhook_type != WebhookTypeInterface::DELETE_UNSORTED){
            $lead_array = GetLeadArrayByWebhook::run($request);
            $lead_for_analytics_dto = LeadForAnalyticsDto::fromLeadArrayFromWebhook($lead_array);
        }

        # Если это неразобранное - дергаем тело сделки запросом
        elseif($webhook_type == WebhookTypeInterface::DELETE_UNSORTED){
            $lead_id = GetLeadIdByWebhook::run($request);
            $lead = $api_client->leads()->getOne($lead_id);
            $lead_for_analytics_dto = LeadForAnalyticsDto::fromLeadModel($lead);
        }

        return $lead_for_analytics_dto;
    }
}