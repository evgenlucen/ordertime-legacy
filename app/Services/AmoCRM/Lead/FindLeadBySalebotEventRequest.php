<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Models\LeadModel;
use App\Configs\amocrmConfig;
use App\Services\Logger\Logger;
use Illuminate\Http\Request;


class FindLeadBySalebotEventRequest
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param Request $request
     * @return LeadModel|bool|null
     * @throws \Exception
     */
    public static function run(AmoCRMApiClient $api_client, Request $request)
    {

        if(empty($request->input('salebot_id')) && empty($request->input('amo_lead_id'))){
            throw new \Exception("no amo lead id, no salebot id");
        }

        if(!empty($request->amo_lead_id)){
            $lead = GetLeadById::run($api_client,$request->input('amo_lead_id'));
        }
        if(empty($lead) && !empty($request->salebot_id)){
            $leads = FindLeadsByCustomFieldValue::run($api_client,amocrmConfig::SB_CF_ID,$request->input('salebot_id'));
            $leads_opened = GetOpenLeadsByLeadsCollection::run($leads);
            if(!$leads_opened->isEmpty()){
                $lead =  $leads->first();
            } else {
                $lead = $leads->first();
            }
        }

        return $lead;

    }

}