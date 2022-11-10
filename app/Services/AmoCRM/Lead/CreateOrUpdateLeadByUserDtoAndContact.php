<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\InvalidArgumentException;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;
use App\Models\DTO\Action\AmoActionDto;
use App\Models\Dto\Getcourse\UserDto;

class CreateOrUpdateLeadByUserDtoAndContact
{

    /**
     * @param AmoCRMApiClient $api_client
     * @param UserDto $user
     * @param ContactModel $contact
     * @param AmoActionDto $action_params
     * @return LeadModel|bool
     * @throws InvalidArgumentException
     */
    public static function run(AmoCRMApiClient $api_client,
                               UserDto $user,
                               ContactModel $contact,
                               AmoActionDto $action_params = null
    )
    {
        # ищем сделки
        $leads_collection = GetOpenedLeadsByContactModel::run($api_client, $contact);

        if (!$leads_collection->isEmpty()) {
            # если нашли - обновляем
            $lead = $leads_collection->first();
            $lead = UpdateLeadModelByUserDto::run($lead,$user);
            if(!empty($action_params)) {  $lead = UpdateLeadModelByAmoActionDto::run($lead, $action_params); }
            $lead = UpdateLeadByLeadModel::run($api_client, $lead);
        }
        //$lead = GetLeadWithoutDealId::run($leads_collection);
        # если не нашли - создаем
        else {
            $lead = new LeadModel();
            $lead = UpdateLeadModelByUserDto::run($lead, $user);
            if(!empty($action_params)) { $lead = UpdateLeadModelByAmoActionDto::run($lead, $action_params); }
            $lead = CreateLeadByLeadModel::run($api_client, $lead);
            # связываем с контактом
            $linked = LinkedToContact::run($api_client,$lead,$contact);
        }


        return $lead;
    }

}