<?php

namespace App\Services\AmoCRM\Lead;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\LeadModel;

final class UpdateStatusLeadById
{

    /**
     * @param AmoCRMApiClient $api_client
     * @param int $lead_id
     * @param int $status_id
     * @param int $pipeline_id
     * @return LeadModel|bool
     */
    public static function run(AmoCRMApiClient $api_client,int $lead_id, int $status_id, int $pipeline_id)
    {
        $lead = GetLeadById::run($api_client,$lead_id);

        if(empty($lead)) { return false; }

        $lead->setStatusId($status_id);
        $lead->setPipelineId($pipeline_id);

        try {
            $result = $api_client->leads()->updateOne($lead);
        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
        }

        return  $result;

    }

}