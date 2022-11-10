<?php


namespace App\Services\AmoCRM\Info;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;

class AmoInfoGetUsers
{
    public static function run(AmoCRMApiClient $api_client)
    {
        try {
            return $api_client->users()->get()->toArray();
        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            printError($e);
        }
    }

}