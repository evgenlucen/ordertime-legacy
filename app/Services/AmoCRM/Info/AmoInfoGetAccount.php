<?php


namespace App\Services\AmoCRM\Info;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;

class AmoInfoGetAccount
{
    public static function run(AmoCRMApiClient $api_client)
    {
        try {
            return $api_client->account()->getCurrent();
        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            dd($e);
        }
    }

}