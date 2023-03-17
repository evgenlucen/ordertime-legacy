<?php

namespace App\Configs;

class amocrmConfig
{
    /* API CLIENT */
    public const DIR_ENV = __DIR__ . DIRECTORY_SEPARATOR . '../../.env';
    public const DIR_TOKEN_FILE = __DIR__ . DIRECTORY_SEPARATOR . '../amo_token_file.json';
    /* LEADS CF */
    public const SB_CF_ID = 905277;
    #public const CF_ID_PRODUCT_NAME = ;
    public const CF_ID_COUNTRY = 972495;
    public const CF_ID_CITY = 972497;

    /* ANALYTICS MARKUP */
    public const UTM_SOURCE_CF_ID = 345263;
    public const UTM_MEDIUM_CF_ID = 345265;
    public const UTM_CAMPAIGN_CF_ID = 345267;
    public const UTM_TERM_CF_ID = 345269;
    public const UTM_CONTENT_CF_ID = 345271;


    /* GETCOURSE */
    public const CF_GC_DEAL_ID = 320585;
    public const CF_GC_DEAL_LINK = 904845;
    public const CF_GC_PAYMENT_LINK = 905271;
    public const CF_GC_PAID_MONEY = 905275;
    public const CF_GC_POSITIONS = 905273;


    /* CONTACT CF */
    public const PHONE_CF_ID = 220223;
    public const EMAIL_CF_ID = 220225;
    public const CF_GC_USER_LINK = 905267;
    public const CF_GC_USER_ID = 905269;

    /* PIPELINES */
    public const PIPELINE_PAID = 3656251;

    public const PIPELINE_LIFE_MANAGEMENT = 6588258;

    public const STATUS_BOUNCE = 143;


    /* Отдел продаж */
    public const STATUS_ALL_LEADS = 35657392; // новый лид
    public const STATUS_CREATED_ORDER = 54626350;
    public const STATUS_PREPAYMENT_SUCCESS = 54626354;

    /* Life management */
    public const STATUS_START = 56002474;


    public const STATUS_PAYMENT_SUCCESS = 142;
    # нерабочие статусы
    public const STATUSES_NON_WORKED = [142, 143];
    # рабочие воронки

    public const PIPELINES_WORKED = [self::PIPELINE_PAID];
    /* USERS */
    public const USER_ROP = 6420658; //Имя Время порядка


    public const RESPONSIBLE_USER_ID = 6420658;
    /** SERVICE MESSAGE */
    public const NAME_SERVICE_MESSAGE = "EngineTun";
    public const TASK_TYPE_DOUBLE_CONTACT = 2785490;

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
}
