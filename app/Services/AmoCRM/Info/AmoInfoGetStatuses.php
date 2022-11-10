<?php


namespace App\Services\AmoCRM\Info;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use App\Models\AmoCRM\Status;

class AmoInfoGetStatuses
{
    public static function run(AmoCRMApiClient $api_client)
    {
        try {
           $pipelines = $api_client->pipelines()->get();
           foreach ($pipelines as $pipeline) {
               $statuses = $pipeline->getStatuses();
               foreach ($statuses as $status) {
                  $statuses_array[$pipeline->getName() . ' - ' .$pipeline->getId()][] = $status->toArray();
               }
           }
           return $statuses_array;

        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            printError($e);
        }
    }

}