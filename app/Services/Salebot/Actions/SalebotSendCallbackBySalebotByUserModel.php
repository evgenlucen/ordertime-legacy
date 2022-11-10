<?php


namespace App\Services\Salebot\Actions;


use App\Configs\salebotConfig;
use App\Models\Dto\Action\SalebotActionDto;
use App\Models\Dto\Bizon\UserMetaDto;
use App\Services\Salebot\src\Salebot;
use App\Services\Salebot\Tasks\GetSalebotCallbackMessageByUserModel;

class SalebotSendCallbackBySalebotByUserModel
{
    /**
     * @param UserMetaDto $user
     * @return \Exception|\GuzzleHttp\Exception\GuzzleException|string
     */
    public static function run(UserMetaDto $user)
    {
        $salebot_action = new SalebotActionDto();
        $salebot_client = new Salebot(salebotConfig::getApiKey());
        $salebot_action->message = GetSalebotCallbackMessageByUserModel::run($user);
        if(empty($user->getP1())){
            return 'no p1-salebot_id';
        }
        if(empty($salebot_action->message)){
            return 'no message';
        }
        return $salebot_client->callback($user->getP1(),$salebot_action->message,$salebot_action->vars);

    }

}