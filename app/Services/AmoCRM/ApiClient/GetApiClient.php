<?php

namespace App\Services\AmoCRM\ApiClient;

use AmoCRM\Client\AmoCRMApiClient;
use App\Configs\amocrmConfig;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Symfony\Component\Dotenv\Dotenv;


class GetApiClient
{

    private $apiClient;

    public function __construct()
    {

        $apiClient = $this->getNotAuthApiClient();

        $accessToken = TokenAction::getToken();
        $apiClient->setAccessToken($accessToken)
            ->setAccountBaseDomain($accessToken->getValues()['baseDomain'])
            ->onAccessTokenRefresh(
                function (AccessTokenInterface $accessToken, string $baseDomain) {
                    TokenAction::saveToken(
                        [
                            'accessToken' => $accessToken->getToken(),
                            'refreshToken' => $accessToken->getRefreshToken(),
                            'expires' => $accessToken->getExpires(),
                            'baseDomain' => $baseDomain,
                        ]
                    );
                }
            );

        $this->apiClient = $apiClient;
    }

    public static function getNotAuthApiClient()
    {
        $dotenv = new Dotenv();
        $dotenv->load(amocrmConfig::DIR_ENV, amocrmConfig::DIR_ENV);

        $clientId = $_ENV['CLIENT_ID'];
        $clientSecret = $_ENV['CLIENT_SECRET'];
        $redirectUri = $_ENV['CLIENT_REDIRECT_URI'];

        return  new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);

    }


    public static function getApiClient()
    {
        $api_client = new self();
        return $api_client->apiClient;
    }

}