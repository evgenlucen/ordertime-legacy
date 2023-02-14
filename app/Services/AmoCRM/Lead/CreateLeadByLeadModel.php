<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\LeadModel;
use App\Services\Logger\Logger;

class CreateLeadByLeadModel
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param LeadModel $lead_model
     * @return LeadModel|bool
     */
    public static function run(AmoCRMApiClient $api_client,LeadModel $leadModel)
    {
        try {
            return $api_client->leads()->addOne($leadModel);
        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            Logger::writeToLog(
                [
                    'error' => "Обновление сделки" . $e->getMessage() . " - " . $e->getDescription() . "-" . $e->getPrevious(),
                    'leadModel' => $leadModel
                ],
                config('logging.dir_error')
            );
            return false;
        }

        return false;

    }

}
