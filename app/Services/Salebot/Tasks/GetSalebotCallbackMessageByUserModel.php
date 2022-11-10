<?php


namespace App\Services\Salebot\Tasks;


use App\Configs\salebotConfig;
use App\Models\Dto\Bizon\UserMetaDto;

class GetSalebotCallbackMessageByUserModel
{
    /**
     * Вернуть текст callback в зависимости от длительности просмотра вебинара
     * @param UserMetaDto $user
     * @return bool|string
     */
    public static function run(UserMetaDto $user)
    {
        if($user->getIsViewSalesPart()){
            return salebotConfig::CALLBACK_TEXT_VIEW_SALES_PART;
        } elseif($user->getIsViewContentPart()){
            return salebotConfig::CALLBACK_TEXT_VIEW_CONTENT_PART;
        } elseif($user->getIsVisitWebinar()){
            return salebotConfig::CALLBACK_TEXT_VIEW_WEB;
        } else {
            return false;
        }

    }
}