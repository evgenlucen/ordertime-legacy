<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;
use App\Models\DTO\Action\AmoActionDto;
use App\Models\Dto\Getcourse\DealDto;

class CreateOrUpdateLeadByDealDtoAndContact
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param DealDto $deal
     * @param ContactModel $contact
     * @param AmoActionDto|null $action_params
     * @return LeadModel|bool
     */
    public static function run(AmoCRMApiClient $api_client,
        DealDto $deal,
        ContactModel $contact,
        AmoActionDto $action_params = null
    )
    {
        # ищем сделки
        $leads_collection = GetOpenedLeadsByContactModel::run($api_client, $contact);

        if (!$leads_collection->isEmpty()) {
            # если нашли - обновляем
            $lead = $leads_collection->first();
            $lead = UpdateLeadModelByDealDto::run($lead,$deal);
            if(!empty($action_params)) {  $lead = UpdateLeadModelByAmoActionDto::run($lead, $action_params); }
            $lead = UpdateLeadByLeadModel::run($api_client, $lead);
        }
        //$lead = GetLeadWithoutDealId::run($leads_collection);
        # если не нашли - создаем
        else {
            $lead = new LeadModel();
            $lead = UpdateLeadModelByDealDto::run($lead, $deal);
            if(!empty($action_params)) { $lead = UpdateLeadModelByAmoActionDto::run($lead, $action_params); }
            $lead = CreateLeadByLeadModel::run($api_client, $lead);
            # связываем с контактом
            $linked = LinkedToContact::run($api_client,$lead,$contact);
        }

        return $lead;
    }

}