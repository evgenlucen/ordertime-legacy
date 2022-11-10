<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Models\LeadModel;
use App\Configs\amocrmConfig;
use App\Models\Dto\Bizon\UserMetaDto;
use App\Services\AmoCRM\Contact\FindContactsByQuery;


class GetLeadByBizonUserMetaDto
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param UserMetaDto $user
     * @return LeadModel|bool|null
     * @throws \Exception
     */
    public static function run(AmoCRMApiClient $api_client, UserMetaDto $user)
    {
        $amo_lead_id = $user->getP3();
        $salebot_id = $user->getP1();
        $phone = $user->getPhone();

        /** Поиск по Amo Lead ID */
        if (!empty($amo_lead_id) && strlen($amo_lead_id) > 5) {
            $lead = GetLeadById::run($api_client, $amo_lead_id);
            if (!empty($lead)) {
                return $lead;
            }
        }

        /** Поиск по salebot id  */
        if(!empty($salebot_id) && strlen($salebot_id) > 5){
            $leads_collection = FindLeadsByCustomFieldValue::run($api_client,amocrmConfig::SB_CF_ID,$salebot_id);
            $leads_collection = GetOpenLeadsByLeadsCollection::run($leads_collection);
            if(!$leads_collection->isEmpty()){
                return $leads_collection->first();
            }
        }

        /** Поиски по phone */
        if(!empty($phone) && strlen($phone) > 5){
            $contacts_collection = FindContactsByQuery::run($api_client,$phone);
            if(!$contacts_collection->isEmpty()){
                $leads_collection = GetOpenedLeadsByContactsCollection::run($api_client,$contacts_collection);
                if(!$leads_collection->isEmpty()){
                    return $leads_collection->first();
                }
            }
        }

        return false;

    }

}