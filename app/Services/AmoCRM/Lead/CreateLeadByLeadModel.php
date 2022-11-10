<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\LeadModel;

class CreateLeadByLeadModel
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param LeadModel $lead_model
     * @return LeadModel|bool
     */
    public static function run(AmoCRMApiClient $api_client,LeadModel $lead_model)
    {
        try {
            return $api_client->leads()->addOne($lead_model);
        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            return false;
        }

    }

}