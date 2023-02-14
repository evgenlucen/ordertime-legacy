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
     * @return LeadModel|bool
     */
    public static function run(AmoCRMApiClient $api_client,LeadModel $lead_model)
    {
        try {
            return $api_client->leads()->updateOne($lead_model);
        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            Logger::writeToLog(
                [
                    'error' => "Обновление сделки" . $e->getMessage() . " - " . $e->getDescription() . "-" . $e->getPrevious(),
                    'description' => var_export($e->getLastRequestInfo(), true)
                ],
                config('logging.dir_error')
            );
            return false;
        }

        return false;

    }
}
