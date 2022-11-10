<?php

namespace App\Configs;

class salebotConfig
{
    //TODO CHANGE ME
    public const CALLBACK_TEXT_VIEW_WEB = 'visit_webinar';
    public const CALLBACK_TEXT_VIEW_CONTENT_PART = 'view_content_part';
    public const CALLBACK_TEXT_VIEW_SALES_PART = 'view_sales_part';

    public static function getApiKey()
    {
        return env('SALEBOT_API_KEY');
    }

}
