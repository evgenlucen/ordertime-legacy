<?php

namespace App\Jobs;

use App\Configs\amocrmConfig;
use App\Jobs\Commands\EventGcDealJobCommand;
use App\Services\AmoCRM\Contact\CreateOrUpdateContactByUserDto;
use App\Services\AmoCRM\Lead\CreateOrUpdateLeadByDealDtoAndContact;
use App\Services\AmoCRM\Lead\FindLeadsByCustomFieldValue;
use App\Services\AmoCRM\Lead\UpdateLeadByLeadModel;
use App\Services\AmoCRM\Lead\UpdateLeadModelByAmoActionDto;
use App\Services\AmoCRM\Lead\UpdateLeadModelByDealDto;
use App\Services\Logger\Logger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class EventGcDealJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;


    public EventGcDealJobCommand $command;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EventGcDealJobCommand $command)
    {
        $this->command = $command;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle(): void
    {
        sleep(1);
        /** Особая бизнес логика */
        // Есть такое понятние как Нулевой заказ. Это заказ с суммой = 0.
        // если cost_money = 0 / empty - это Нулевой заказ
        // его мы отправляем в Новый лид.
        if(empty($this->command->dealDto->getCostMoney())){
            $this->command->actionParam->getAmocrmAction()->setStatusId(amocrmConfig::STATUS_ALL_LEADS);
            $isZeroDeal = true;
        } else {
            $isZeroDeal = false;
        }

        # ищем по deal_id
        $leads_collection = FindLeadsByCustomFieldValue::run(
            $this->command->apiClient,
            amocrmConfig::CF_GC_DEAL_ID,
            $this->command->dealDto->getId()
        );

        # если не нашли
        if($leads_collection->isEmpty()){
            # ищем или создаем контакт
            $contact = CreateOrUpdateContactByUserDto::run($this->command->apiClient,$this->command->dealDto->getUser());
            # обновляем существующую сделку или создаем новую
            $lead = CreateOrUpdateLeadByDealDtoAndContact::run(
                $this->command->apiClient,
                $this->command->dealDto,
                $contact,
                $this->command->actionParam->getAmocrmAction()
            );
            $data_log['contact'] = $contact->toArray();
        } else {
            # если нашли
            $lead = $leads_collection->first();
            $lead = UpdateLeadModelByAmoActionDto::run($lead,$this->command->actionParam->getAmocrmAction());
            $lead = UpdateLeadModelByDealDto::run($lead,$this->command->dealDto);
            $lead = UpdateLeadByLeadModel::run($this->command->apiClient,$lead);
        }

        $data_log['action_param'] = $this->command->actionParam;
        $data_log['deal'] = $this->command->dealDto->toArray();
        $data_log['lead'] = $lead->toArray();


        Logger::writeToLog($data_log,config('logging.dir_getcourse_deal_events'));

    }
}
