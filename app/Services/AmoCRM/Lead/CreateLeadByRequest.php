<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\LeadModel;
use App\Services\AmoCRM\CustomFields\CreateCustomFieldsCollectionByRequest;
use Illuminate\Http\Request;

class CreateLeadByRequest
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param Request $request
     * @return LeadModel|bool
     */
    public static function run(AmoCRMApiClient $api_client,Request $request)
    {
        $lead = new LeadModel();
        $custom_fields = CreateCustomFieldsCollectionByRequest::run($request,EntityTypesInterface::LEAD);
        $lead->setCustomFieldsValues($custom_fields);
        $lead->setResponsibleUserId(config('amocrm.responsible_user_id'));
        $lead->setStatusId(config('amocrm.status_start_marathon_id'));
        $lead->setPipelineId(config('amocrm.pipeline_worker_id'));

        try {
            return $api_client->leads()->addOne($lead);
        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            return false;
        }
    }

}