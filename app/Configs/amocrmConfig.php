<?php

namespace App\Configs;

class amocrmConfig
{
    /* API CLIENT */
    public const DIR_ENV = __DIR__ . DIRECTORY_SEPARATOR . '../../.env';
    public const DIR_TOKEN_FILE = __DIR__ . DIRECTORY_SEPARATOR . '../amo_token_file.json';
    /* LEADS CF */
    public const SB_CF_ID = 976075;
    public const DSM_CF_IF = '';
    public const CF_ID_PRODUCT_NAME = 976177;
    public const CF_ID_COUNTRY = 972495;
    public const CF_ID_CITY = 972497;
    public const CF_ID_UTC = 972499;

    /* ANALYTICS MARKUP */
    public const FBP_CF_ID = 976191;
    public const GOOGLE_CID_CF_ID = 842127;
    public const UTM_SOURCE_CF_ID = 842107;
    public const UTM_MEDIUM_CF_ID = 842103;
    public const UTM_CAMPAIGN_CF_ID = 842105;
    public const UTM_TERM_CF_ID = 842109;
    public const UTM_CONTENT_CF_ID = 842101;
    public const CUSTOM_SOURCE_CF_ID = '';
    public const REFERRER_CF_ID = 842111;


    /* GETCOURSE */
    public const CF_GC_DEAL_ID = 976181;
    public const CF_GC_DEAL_LINK = 976179;
    public const CF_GC_PAYMENT_LINK = 976183;
    public const CF_GC_PAID_MONEY = 976193;
    #public const CF_GC_REMAINING_TO_PAY = 379055;
    public const CF_GC_POSITIONS = 976177;


    /* CONTACT CF */
    public const PHONE_CF_ID = 842093;
    public const EMAIL_CF_ID = 842095;
    public const CF_GC_USER_LINK = 976187;
    public const CF_GC_USER_ID = 976185;

    /* PIPELINES */
    public const PIPELINES_ID_FOR_UA = [6069535];
    public const PIPELINE_TG_COURSE = 6069535;
    public const PIPELINE_PAID = 5174095; //не связана с автоворонкой

    const PIPELINE_FINPLAN = 5200918;


    /* STATUSES */
    /* Отдел доходимости */
    public const STATUS_REGISTRATION = 52648171;
    public const STATUS_OPEN_1_LESSON = 52650076;
    public const STATUS_OPEN_2_LESSON = 52650079;
    public const STATUS_OPEN_3_LESSON = 52650082;
    public const STATUS_REGISTRATION_TO_WEBINAR = 52648174;

    public const STATUS_OPENING_WEB = 52650085;


    public const STATUS_BOUNCE = 143;
    /* Legacy pipeline */
    public const LEGACY_STATUS_BUILD_SENT = 46331179;


    public const LEGACY_STATUS_PARTIAL_PAYMENT_SUCCESS = 46331182;
    /* Отдел продаж */
    public const STATUS_ALL_LEADS = 52650088;
    public const STATUS_BUILD = 52650094;
    public const STATUS_CREATED_ORDER = 52648177;
    public const STATUS_PARTIAL_PAYMENT_SUCCESS = 52650097;

    /* Фин.грамонтность */
    public const STATUS_PAID_TRIPWARE = 46579162;


    public const STATUS_PAID_SUCCESS = 142;
    # нерабочие статусы
    public const STATUSES_NON_WORKED = [142, 143];
    # рабочие воронки

    public const PIPELINES_WORKED = [self::PIPELINE_TG_COURSE,self::PIPELINE_PAID];
    /* USERS */
    public const USER_ROP = 7820154;


    public const RESPONSIBLE_USER_ID = 7820154;
    /** SERVICE MESSAGE */
    public const NAME_SERVICE_MESSAGE = "EngineTun";
    public const TASK_TYPE_DOUBLE_CONTACT = 2716338;
    public const TASK_TYPE_DOUBLE_LEAD = 2716342;


    /**
     * В ключе - имя переменной из входящего массива
     * @return string[][]
     */
    public static function getCfNameIdMapLead(): array
    {
        return [
            'gc_deal_link' => ['id' => self::CF_GC_DEAL_LINK, 'type' => 'text'],
            #'left_cost_money' => ['id' => self::CF_GC_REMAINING_TO_PAY, 'type' => 'text'],
            'deal_id' => ['id' => self::CF_GC_DEAL_ID, 'type' => 'text'],
            'positions' => ['id' => self::CF_GC_POSITIONS, 'type' => 'text'],
            'cost_money' => ['id' => self::CF_GC_PAID_MONEY, 'type' => 'text'],
            'payment_link' => ['id' => self::CF_GC_PAYMENT_LINK, 'type' => 'text'],
            'payed_money' => ['id' => self::CF_GC_PAID_MONEY, 'type' => 'text'],
            'utm_source' => ['id' => self::UTM_SOURCE_CF_ID, 'type' => 'text'],
            'utm_medium' => ['id' => self::UTM_MEDIUM_CF_ID, 'type' => 'text'],
            'utm_campaign' => ['id' => self::UTM_CAMPAIGN_CF_ID, 'type' => 'text'],
            'utm_term' => ['id' => self::UTM_TERM_CF_ID, 'type' => 'text'],
            'utm_content' => ['id' => self::UTM_CONTENT_CF_ID, 'type' => 'text'],
            'page' => ['id'=> self::REFERRER_CF_ID, 'type' => 'text'],
        ];
    }

    public static function getCfNameIdMapContact(): array
    {
        return [
            'email' => ['id' => self::EMAIL_CF_ID, 'type' => 'text'],
            'phone' => ['id' => self::PHONE_CF_ID, 'type' => 'text'],
            'user_id' => ['id' => self::CF_GC_USER_ID, 'type' => 'text'],
            'gc_user_link' => ['id' => self::CF_GC_USER_LINK, 'type' => 'text'],
        ];
    }

    public const SOURCE_MAP = '';



}
