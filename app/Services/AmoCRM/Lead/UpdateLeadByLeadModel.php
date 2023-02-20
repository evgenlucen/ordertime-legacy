<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\LeadModel;
use App\Services\Logger\Logger;

class UpdateLeadByLeadModel
{


    /**
     * @param AmoCRMApiClient $api_client
     * @param LeadModel $lead_model
     * @return LeadModel
     */
    public static function run(AmoCRMApiClient $api_client,LeadModel $lead_model): LeadModel
    {
        try {
            $lead_model->setUpdatedBy(null);
            $lead_model->setCreatedBy(null);
            $lead_model = $api_client->leads()->updateOne($lead_model);
        } catch (AmoCRMMissedTokenException|AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            Logger::writeToLog(
                [
                    'error' => "Обновление сделки " . $e->getMessage() . " - " . $e->getDescription() . "-" . $e->getPrevious(),
                    'description' => var_export($e->getLastRequestInfo(), true),
                    'lead' => $lead_model
                ],
                config('logging.dir_error')
            );
            var_dump($e->getMessage());
            die();
        }

        return $lead_model;
    }
}
