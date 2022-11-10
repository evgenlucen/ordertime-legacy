<?php


namespace App\Configs;


class leadcollectConfig
{


    public const TAGS = ['заявка'];
    public const PROJECT_NAME = "defin";
    public const STATUS_INT_AMOCRM = TRUE;
    public const STATUS_INT_TG_NOTIFICATION = FALSE;
    public const STATUS_INT_GOOGLE_SPREADSHEETS = FALSE;
    public const STATUS_DEBUG = TRUE;
    public const STATUS_LOG = TRUE;
    public const DOUBLE_CHECK_PHONE = TRUE;
    public const DOUBLE_CHECK_EMAIL = TRUE;
    public const TELEGRAM_BOT_TOKEN = TRUE;
    public const TELEGRAM_CHAT_ID_LIST = [];
    public const FILE_PHONES = __DIR__ . DIRECTORY_SEPARATOR . '../../storage/logs/phones.json';
    public const FILE_EMAIL =  __DIR__ . DIRECTORY_SEPARATOR . '../../storage/logs/emails.json';
    public const FILE_LOG = __DIR__ . DIRECTORY_SEPARATOR . '../../storage/logs/tilda_debug.json';


}
