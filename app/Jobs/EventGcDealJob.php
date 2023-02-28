<?php

namespace App\Jobs;

use AmoCRM\Client\AmoCRMApiClient;
use App\Configs\amocrmConfig;
use App\Models\Dto\Action\ActionParamsDto;
use App\Models\Dto\GetCourse\DealDto;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use App\Services\AmoCRM\Contact\CreateOrUpdateContactByUserDto;
use App\Services\AmoCRM\Lead\CreateOrUpdateLeadByDealDtoAndContact;
use App\Services\AmoCRM\Lead\FindLeadsByCustomFieldValue;
use App\Services\AmoCRM\Lead\UpdateLeadByLeadModel;
use App\Services\AmoCRM\Lead\UpdateLeadModelByAmoActionDto;
use App\Services\AmoCRM\Lead\UpdateLeadModelByDealDto;
use App\Services\AmoCRM\Task\CreateDoubleTask;
use App\Services\AmoCRM\Task\CreateTask;
use App\Services\Logger\Logger;
use Carbon\Traits\Serialization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EventGcDealJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected string $eventName;

    protected DealDto $dealDto;

    protected ActionParamsDto $actionParam;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        string          $eventName,
        DealDto         $dealDto,
        ActionParamsDto $actionParam)
    {
        $this->eventName = $eventName;
        $this->dealDto = $dealDto;
        $this->actionParam = $actionParam;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle(): void
    {
        sleep(2);
        /** Особая бизнес логика */
        // Есть такое понятние как Нулевой заказ. Это заказ с суммой = 0.
        // если cost_money = 0 / empty - это Нулевой заказ
        // его мы отправляем в Новый лид.
        if (empty($this->dealDto->getCostMoney())) {
            $this->actionParam->getAmocrmAction()->setStatusId(amocrmConfig::STATUS_ALL_LEADS);
            $isZeroDeal = true;
        } else {
            $isZeroDeal = false;
        }

        $apiClient = GetApiClient::getApiClient();

        # ищем по deal_id
        $leads_collection = FindLeadsByCustomFieldValue::run(
            $apiClient,
            amocrmConfig::CF_GC_DEAL_ID,
            $this->dealDto->getId()
        );

        # если не нашли
        if ($leads_collection->isEmpty()) {
            # ищем или создаем контакт
            $contact = CreateOrUpdateContactByUserDto::run($apiClient, $this->dealDto->getUser());
            # обновляем существующую сделку или создаем новую
            $lead = CreateOrUpdateLeadByDealDtoAndContact::run(
                $apiClient,
                $this->dealDto,
                $contact,
                $this->actionParam->getAmocrmAction()
            );
            $data_log['contact'] = $contact->toArray();
        } else {
            # если нашли
            $lead = $leads_collection->first();
            $lead = UpdateLeadModelByAmoActionDto::run($lead, $this->actionParam->getAmocrmAction());
            $lead = UpdateLeadModelByDealDto::run($lead, $this->dealDto);
            $lead = UpdateLeadByLeadModel::run($apiClient, $lead);

            $addedTask = CreateTask::lead($apiClient,'был на последнем мероприятии, взять в работу',$lead->getId(),1,48);
            $data_log['added_task'] = $addedTask->getId();
        }

        $data_log['action_param'] = $this->actionParam;
        $data_log['deal'] = $this->dealDto->toArray();
        $data_log['lead'] = $lead->toArray();


        Logger::writeToLog($data_log, config('logging.dir_getcourse_deal_events_queue'));

    }
}
