<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Exceptions\InvalidArgumentException;
use AmoCRM\Models\LeadModel;
use App\Services\AmoCRM\Lead\Tasks\GetLeadArrayByWebhook;
use App\Services\AmoCRM\Lead\Tasks\GetTypeEventByWebhook;
use Illuminate\Http\Request;

class GetLeadModelByWebhook
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param Request $request
     * @return LeadModel|null
     * @throws InvalidArgumentException
     */
    public static function run(AmoCRMApiClient $api_client, Request $request)
    {
        $webhook_type = GetTypeEventByWebhook::run($request);
        if($webhook_type == "change_status" or $webhook_type == "add"){
            $lead = LeadModel::fromArray(GetLeadArrayByWebhook::run($request));
        } else if($webhook_type == "delete_unsorted"){
            $lead_id = $request->unsorted['delete'][0]['accept_result']['leads'][0];
            try {
                $lead = $api_client->leads()->getOne($lead_id);
            } catch (AmoCRMMissedTokenException $e) {
            } catch (AmoCRMoAuthApiException $e) {
            } catch (AmoCRMApiException $e) {
                throw new \Exception("Не удалось получить лид по id");
            }
        }

        return $lead;
    }

}