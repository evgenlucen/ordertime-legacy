<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\LeadModel;

final class GetLeadById
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param int $lead_id
     * @return LeadModel|null
     */
    public static function run(AmoCRMApiClient $api_client, int $lead_id): ?LeadModel
    {
        try {
            $lead = $api_client->leads()->getOne($lead_id, [LeadModel::CONTACTS]);
        } catch (AmoCRMMissedTokenException|AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            return null;
        }

        if(empty($lead)){
            return null;
        } else {
            return $lead;
        }

    }

}
