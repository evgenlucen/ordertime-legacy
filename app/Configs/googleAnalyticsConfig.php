<?php

namespace App\Configs;

class googleAnalyticsConfig
{
    public const EVENT_CATEGORY_AMOCRM = 'amoCRM';

    public static function getApiKey(): string
    {
        return env('GA_API_KEY');
    }

    public static function getStreamId(): string
    {
        return env('GA_STREAM_ID');
    }

}
