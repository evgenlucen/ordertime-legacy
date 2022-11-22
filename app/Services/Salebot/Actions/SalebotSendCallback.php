<?php

namespace App\Services\Salebot\Actions;

use App\Configs\salebotConfig;
use App\Models\Dto\Action\SalebotActionDto;
use App\Services\Salebot\src\Salebot;

class SalebotSendCallback
{
    public static function run(int $salebot_client_id, SalebotActionDto $salebot_action)
    {
        $salebot_client = new Salebot(salebotConfig::getApiKey());

        return  $salebot_client->callback($salebot_client_id,$salebot_action->message,$salebot_action->vars);
    }
}
