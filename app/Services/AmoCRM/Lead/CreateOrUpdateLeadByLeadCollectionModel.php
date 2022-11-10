<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;
use App\Models\Dto\Action\AmoActionDto;
use App\Models\Dto\LeadCollect\LcModel;

class CreateOrUpdateLeadByLeadCollectionModel
{
    public static function run(AmoCRMApiClient $api_client,
                               LcModel $lc_model,
                               ContactModel $contact,
                               AmoActionDto $action_params = null)
    {
        # ищем сделки
        $leads_collection = GetOpenedLeadsByContactModel::run($api_client, $contact);

        if (!$leads_collection->isEmpty()) {
            # если нашли - обновляем
            $lead = $leads_collection->first();
            $lead = UpdateLeadModelByLeadCollectionModel::run($lead, $lc_model);
            if (!empty($action_params)) {
                $lead = UpdateLeadModelByAmoActionDto::run($lead, $action_params);
            }
            $lead = UpdateLeadByLeadModel::run($api_client, $lead);
        }

        # если не нашли - создаем
        else {
            $lead = new LeadModel();
            $lead = UpdateLeadModelByLeadCollectionModel::run($lead, $lc_model);
            if (!empty($action_params)) {
                $lead = UpdateLeadModelByAmoActionDto::run($lead, $action_params);
            }
            $lead = CreateLeadByLeadModel::run($api_client, $lead);
            # связываем с контактом
            $linked = LinkedToContact::run($api_client, $lead, $contact);
        }

        return $lead;
    }

}