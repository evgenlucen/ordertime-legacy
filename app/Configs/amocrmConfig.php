<?php

namespace App\Configs;

class amocrmConfig
{
    /* API CLIENT */
    public const DIR_ENV = __DIR__ . DIRECTORY_SEPARATOR . '../../.env';
    public const DIR_TOKEN_FILE = __DIR__ . DIRECTORY_SEPARATOR . '../amo_token_file.json';
    /* LEADS CF */
    public const SB_CF_ID = 379401;
    public const DSM_CF_IF = '';
    public const CF_ID_PRODUCT_NAME = 379105;

    /* ANALYTICS MARKUP */
    public const FBP_CF_ID = 378997;
    public const GOOGLE_CID_CF_ID = 282449;
    public const UTM_SOURCE_CF_ID = 282429;
    public const UTM_MEDIUM_CF_ID = 282425;
    public const UTM_CAMPAIGN_CF_ID = 282427;
    public const UTM_TERM_CF_ID = 282431;
    public const UTM_CONTENT_CF_ID = 282423;
    public const CUSTOM_SOURCE_CF_ID = '';
    public const REFERRER_CF_ID = 282437;


    /* GETCOURSE */
    public const CF_GC_DEAL_ID = 379049;
    public const CF_GC_DEAL_LINK = 378999;
    public const CF_GC_PAYMENT_LINK = 379051;
    public const CF_GC_PAID_MONEY = 379053;
    public const CF_GC_REMAINING_TO_PAY = 379055;
    public const CF_GC_POSITIONS = 379105;


    /* CONTACT CF */
    public const PHONE_CF_ID = 282415;
    public const EMAIL_CF_ID = 282417;
    public const CF_GC_USER_LINK = 379251;
    public const CF_GC_USER_ID = 543049;

    /* PIPELINES */
    public const PIPELINES_ID_FOR_UA = [4963063,4972738];
    public const PIPELINE_WORKED = 4963063;
    public const PIPELINE_PAID = 4972738;

    /* STATUSES */
    /* Отдел доходимости */
    public const STATUS_REGISTRATION = 44821654;
    public const STATUS_SEND_WEBINAR_LINK = 44821657;
    public const STATUS_START_WEBINAR = 44821660;
    public const STATUS_VIEW_CONTENT_PART = 44821663;
    public const STATUS_OPENED_RECORD_WEBINAR = 44890363;
    public const STATUS_BOUNCE = 143;



    /* Отдел продаж */
    public const STATUS_ALL_LEADS = 44890396;
    public const STATUS_FORM_SUBMIT = 44890438;
    public const STATUS_PARTIAL_PAYMENT_SUCCESS = 44890441;
    public const STATUS_PAID_SUCCESS = 142;


    # нерабочие статусы
    public const STATUSES_NON_WORKED = [142, 143];
    # рабочие воронки
    public const PIPELINES_WORKED = [self::PIPELINE_WORKED,self::PIPELINE_PAID];

    /* USERS */
    public const USER_ROP = 7740154;
    public const RESPONSIBLE_USER_ID = 7740154;


    /** SERVICE MESSAGE */
    public const NAME_SERVICE_MESSAGE = "EngineTun";


    /**
     * В ключе - имя переменной из входящего массива
     * @return string[][]
     */
    public static function getCfNameIdMapLead()
    {
        return [
            'gc_deal_link' => ['id' => self::CF_GC_DEAL_LINK, 'type' => 'text'],
            'left_cost_money' => ['id' => self::CF_GC_REMAINING_TO_PAY, 'type' => 'text'],
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

    public static function getCfNameIdMapContact()
    {
        return [
            'email' => ['id' => self::EMAIL_CF_ID, 'type' => 'text'],
            'phone' => ['id' => self::PHONE_CF_ID, 'type' => 'text'],
            'user_id' => ['id' => self::CF_GC_USER_LINK, 'type' => 'text'],
            'gc_user_link' => ['id' => self::CF_GC_USER_ID, 'type' => 'text'],
        ];
    }

    public const SOURCE_MAP = '';



}
