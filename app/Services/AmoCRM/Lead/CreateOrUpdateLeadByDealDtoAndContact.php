<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\TagModel;
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
                               DealDto         $deal,
                               ContactModel    $contact,
                               AmoActionDto    $action_params = null
    )
    {
        # ищем открытые сделки полученного контакта
        $leads_collection = GetOpenedLeadsByContactModel::run($api_client, $contact);

        if (!$leads_collection->isEmpty()) {
            # Если нашли
            for ($i = 0; $i < $leads_collection->count(); $i++) {
                $lead = $leads_collection->offsetGet($i);

                //проверим на принадлежность к воронке Лайф-Менеджент
                if (self::isLifeManagementDeal($deal)) {
                    $lead = UpdateLeadModelByDealDto::run($lead, $deal);
                    if (null !== $action_params) {

                        # прописываем начальный статус для ЛМ сделки
                        $action_params->setStatusId(amocrmConfig::STATUS_START);
                        $action_params->setPipelineId(amocrmConfig::PIPELINE_LIFE_MANAGEMENT);
                        $action_params->appendTag('ЛМ');

                        $leadPriorityStatus = GetPriorityStatusByLeadModel::run($lead);
                        $actionPriorityStatus = GetPriorityStatusByAmoActionDto::run($action_params);

                        # если у найденного лида приоритет статуса больше чем у действия - обновляем действие.
                        if ($leadPriorityStatus > $actionPriorityStatus) {
                            $action_params->setStatusId($lead->getStatusId());
                            $action_params->setPipelineId($lead->getPipelineId());
                        }

                        $lead = UpdateLeadModelByAmoActionDto::run($lead, $action_params);
                    }
                }

                # ищем среди них сделку с нулевым бюджетом
                if (self::isZeroCostDealLead($lead)) {
                    # $lead = $leads_collection->first();
                    $lead = UpdateLeadModelByDealDto::run($lead, $deal);
                    if (null !== $action_params) {
                        $leadPriorityStatus = GetPriorityStatusByLeadModel::run($lead);
                        $actionPriorityStatus = GetPriorityStatusByAmoActionDto::run($action_params);
                        # если у найденного лида приоритет статуса больше чем у действия - обновляем действие.
                        if ($leadPriorityStatus > $actionPriorityStatus) {
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

        /* Если нулевая сделка или Из ЛайфМенеджмента - ответственный РОП */
        if (self::isZeroDeal($deal) || self::isLifeManagementDeal($deal)) {
            $lead->setResponsibleUserId(amocrmConfig::RESPONSIBLE_USER_ID);
        } else {
            $lead->setResponsibleUserId($contact->getResponsibleUserId() ?? amocrmConfig::RESPONSIBLE_USER_ID);
        }

        if (null !== $action_params) {
            $lead = UpdateLeadModelByAmoActionDto::run($lead, $action_params);
        }
        $lead = CreateLeadByLeadModel::run($api_client, $lead);
        # связываем её с контактом.
        $linked = LinkedToContact::run($api_client, $lead, $contact);

        return $lead;
    }

    private static function isZeroCostDealLead(LeadModel $lead): bool
    {
        // у сделки в бюджете 0
        if (0 == $lead->getPrice() || empty($lead->getPrice())) {
            // и она не относится к ЛайфМенеджменту
            if ($lead->getPipelineId() !== amocrmConfig::PIPELINE_LIFE_MANAGEMENT) {
                return true;
            }
        }
        return false;
    }

    private static function isZeroDeal(DealDto $deal): bool
    {
        // заказ нулевой Если

        // у сделки в заказа = 0
        if (0 == $deal->getCostMoney()) {
            //нет тегов
            if (empty($deal->getTag())) {
                return true;
            }
            // или тег содержит ЛМ
            if (strpos($deal->getTag(), 'ЛМ') === false) {
                return true;
            }
        }
        return false;

    }

    private static function isLifeManagementDeal(DealDto $deal): bool
    {
        if (empty($deal->getTag())) {
            return false;
        } else {
            return strpos($deal->getTag(), 'ЛМ') !== false;
        }
    }

    private static function isLifeManagementLead(LeadModel $lead): bool
    {
        if ($lead->getTags() === null) {
            return false;
        }

        foreach ($lead->getTags()->getIterator() as $tag) {
            \assert($tag instanceof TagModel);
            if (strpos($tag->getName(), 'ЛМ') !== false) {
                if ($lead->getPipelineId() == amocrmConfig::PIPELINE_LIFE_MANAGEMENT) {
                    return true;
                }
            }
        }

        return false;

    }

}
