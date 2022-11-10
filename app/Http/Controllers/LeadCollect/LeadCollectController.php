<?php

namespace App\Http\Controllers\LeadCollect;


use App\Configs\eventsConfig;
use App\Configs\leadcollectConfig;
use App\Models\Dto\LeadCollect\LcModel;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Contact\CreateOrUpdateContactByLeadCollectionModel;
use App\Services\AmoCRM\Lead\CreateOrUpdateLeadByLeadCollectionModel;
use App\Services\Debug\Debuger;
use App\Services\Leadcollect\LcDoubleCheck;
use App\Services\Leadcollect\LcFormater;
use App\Services\Leadcollect\Tasks\GetProductsNameByProducts;
use App\Services\Logger\Logger;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LeadCollectController extends Controller
{
    public static function run(Request $request)
    {

        $formater = new LcFormater($request->all());
        $double = new LcDoubleCheck();
        $lc_model = new LcModel();

        $data_log['request'] = $request->all();

        $lc_model->setPhone($formater->getClearPhone());
        $lc_model->setEmail($formater->getEmail());
        $lc_model->setLtype($formater->getLtype());
        $lc_model->setTypeLead($formater->getTypeLead());
        $lc_model->setName($formater->getName());

        /* CALL */
        $lc_model->setRec($formater->getRec());
        $lc_model->setDuration($formater->getDuration());
        $lc_model->setCallId($formater->getCallId());


        /* UTM */
        $lc_model->setUtmSource($formater->getUtmSource());
        $lc_model->setUtmMedium($formater->getUtmMedium());
        $lc_model->setUtmCampaign($formater->getUtmCampaign());
        $lc_model->setUtmTerm($formater->getUtmTerm());
        $lc_model->setUtmContent($formater->getUtmContent());

        /* URL */
        $lc_model->setPage($formater->getPage());

        /* Analytics Id */
        $lc_model->setGaCid($formater->getGoogleClientId());
        $lc_model->setFbFbp($formater->getFacebookId());
        $lc_model->setRoistatVisit($formater->getRoistatVisit());
        $lc_model->setYmUid($formater->getYmUid());

        /* Autotunnel data */
        # $lc_model->setSbId($formater->getSalebotId());
        # $lc_model->setAmoLeadId($formater->getAmoLeadId());

        /* Product data  */
        $lc_model->setProducts($formater->getProducts());
        $lc_model->setOrderId($formater->getOrderId());
        $lc_model->setAmount($formater->getAmount());
        $lc_model->setComment($formater->getComment());
        $lc_model->setPromocode($formater->getPromocode());
        $lc_model->setProductQuantity($formater->getProductQuantity());


        /** TAGS */
        if(!empty(leadcollectConfig::TAGS)){
            $lc_model->setTags(leadcollectConfig::TAGS);
        }
        if(!empty($lc_model->getProducts())){
            $lc_model->addTags(GetProductsNameByProducts::run($lc_model->getProducts()));
        }
        if(!empty($lc_model->getPage())){
            $lc_model->addTags([$lc_model->getPage()]);
        }


        if(!empty($formater->getLtype())){
            $lc_model->setLtype($formater->getLtype());
        }

        $double_phone = $double->checkDoubleByPhone($lc_model->getPhone());
        $double_email = $double->checkDoubleByEmail($lc_model->getEmail());
        if($double_phone === FALSE && $double_email === FALSE){
            $lc_model->setDoubleStatus(false);
            $lc_model->setDoubleStatusName('уникальный');
        } else {  $lc_model->setDoubleStatus(true); $lc_model->setDoubleStatusName('дубль'); }

        $data_log['model'] = $lc_model->toArray();

        /* Гугл форма
        if(STATUS_INT_GOOGLE_SPREADSHEETS == TRUE){
            $int_sheets = new LcGSheet();
            $data_log['google_spreadsheets'] = $int_sheets->googleTab($lc_model);
        }
        */

        /* Телеграм уведомления
        if(STATUS_INT_TG_NOTIFICATION == TRUE){
            $tg_notification = new LcTelegram(TELEGRAM_BOT_TOKEN);
            //if(!empty(PROJECT_NAME)) { $tg_notification->addParamToBody(PROJECT_NAME); }
            if(!empty($lc_model->getPhone())) { $tg_notification->addParamToBody($lc_model->getPhone()); }
            if(!empty($lc_model->getEmail())) { $tg_notification->addParamToBody($lc_model->getEmail()); }
            if(!empty($lc_model->getLtype())) { $tg_notification->addParamToBody($lc_model->getLtype()); }
            if(!empty($lc_model->getName())) { $tg_notification->addParamToBody($lc_model->getName()); }
            if(!empty($lc_model->getPage())) { $tg_notification->addParamToBody($lc_model->getPage()); }
            if(!empty($lc_model->getUtmSource())) { $tg_notification->addParamToBody($lc_model->getUtmSource()); }
            if(!empty($lc_model->getUtmTerm())) { $tg_notification->addParamToBody($lc_model->getUtmTerm()); }

            try {
                $data_log['tg_not'] = $tg_notification->sendMessage(TELEGRAM_CHAT_ID_LIST);
            } catch (Exception $e) {
                print_r($e);
            }
        }
        */


        /* Интеграция с AmoCRM */
        // TODO добавить поиск по salebot id и amo_lead_id
        if(leadcollectConfig::STATUS_INT_AMOCRM == TRUE){
            $api_client = GetApiClient::getApiClient();
            $action_params = eventsConfig::getActionParamsDtoByEventName('form_submit')->getAmocrmAction();
            $contact = CreateOrUpdateContactByLeadCollectionModel::run($api_client,$lc_model);
            $lead = CreateOrUpdateLeadByLeadCollectionModel::run($api_client,$lc_model,$contact,$action_params);

            $data_log['lead_createOrUpdate'] = $lead->toArray() ?? $lead;
        }



        /* Логирование */
        if(leadcollectConfig::STATUS_DEBUG == true) {
/*            $write = new \Helpers\JsonHelper();
            if (!empty($lc_model->getPhone())) {
                $write->writePhoneToFile(FILE_PHONES, $lc_model->getPhone());
            }
            if (!empty($lc_model->getEmail())) {
                $write->writeEmailToFile(FILE_EMAIL, $lc_model->getEmail());
            }*/
            if(!empty($data_log)){
                Logger::writeToLog($data_log,leadcollectConfig::FILE_LOG);
            }
        }

        /* DEBUG */
        if(leadcollectConfig::STATUS_DEBUG == true){
            Debuger::debug($data_log);
        }
    }
}
