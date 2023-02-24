<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;
use App\Configs\amocrmConfig;
use App\Models\DTO\Action\AmoActionDto;
use App\Models\Dto\Getcourse\DealDto;
use App\Services\AmoCRM\Pipelines\Statuses\GetPriorityStatusByAmoActionDto;
use App\Services\AmoCRM\Pipelines\Statuses\GetPriorityStatusByLeadModel;

/** Не используй это в других проектах. Тут заложена бизнес логика проекта Время Порядка. */
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
        # ищем открытые сделки полученного контакта
        $leads_collection = GetOpenedLeadsByContactModel::run($api_client, $contact);

        if (!$leads_collection->isEmpty()) {
            # Если нашли
            for($i = 0;$i < $leads_collection->count();$i++ ) {
                $lead = $leads_collection->offsetGet($i);
                # ищем среди них сделку с нулевым бюджетом
                if (self::isZeroCostDeal($lead)) {
                    $lead = $leads_collection->first();
                    $lead = UpdateLeadModelByDealDto::run($lead,$deal);
                    if(null !== $action_params) {
                        $leadPriorityStatus = GetPriorityStatusByLeadModel::run($lead);
                        $actionPriorityStatus = GetPriorityStatusByAmoActionDto::run($action_params);
                        # если у найденного лида приоритет статуса больше чем у действия - обновляем действие.
                        if($leadPriorityStatus > $actionPriorityStatus){
                            $action_params->setStatusId($lead->getStatusId());
                            $action_params->setPipelineId($lead->getPipelineId());
                        }

                        $lead = UpdateLeadModelByAmoActionDto::run($lead, $action_params);
                    }
                    # и обновляем её и выходим
                    return UpdateLeadByLeadModel::run($api_client, $lead);
                }
            }

        }
        # если не нашли нулевую сделку или вообще сделок у контакта
        # создаем новую
        $lead = new LeadModel();
        $lead = UpdateLeadModelByDealDto::run($lead, $deal);
        $lead->setResponsibleUserId($contact->getResponsibleUserId());
        if(null !== $action_params) {
            $lead = UpdateLeadModelByAmoActionDto::run($lead, $action_params);
        }
        $lead = CreateLeadByLeadModel::run($api_client, $lead);
        # связываем её с контактом.
        $linked = LinkedToContact::run($api_client,$lead,$contact);

        return $lead;
    }

    private static function isZeroCostDeal(LeadModel $lead): bool
    {
        return 0 == $lead->getPrice() || empty($lead->getPrice());
    }

}
