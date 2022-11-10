<?php


namespace App\Services\AmoCRM\Info;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Helpers\EntityTypesInterface;

class AmoInfoGetCustomFieldsLead
{
    public static function run(AmoCRMApiClient $api_client)
    {
        try {
            return $api_client->customFields(EntityTypesInterface::LEADS)->get()->toArray();
        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            printError($e);
        }
    }

}