<?php

namespace App\Http\Controllers\AmoCRM;


use AmoCRM\Helpers\EntityTypesInterface;
use App\Services\AmoCRM\Double\ContactDoubleHandler;
use App\Services\AmoCRM\Webhook\GetModelIdByWebhook;
use App\Services\AmoCRM\Webhook\GetModelTypeByWebhook;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AmoAntiDouble extends Controller
{
    public function run(Request $request)
    {
        # TODO List
        # Получить тип вебхука (создание сделки, удаление неразобранного, создание контакта)
        $modelType = GetModelTypeByWebhook::run($request);
        $ids = GetModelIdByWebhook::run($request,$modelType);
        # Передать id сущности для обработки в специализированный для сущности сервис
        if ($modelType === EntityTypesInterface::LEADS){

            # сервис обработки дублей для сделок
            foreach ($ids as $leadId){
                #$result = LeadDoubleHandler::run($leadId);
            }

        } elseif ($modelType === EntityTypesInterface::CONTACTS){
            # сервис обработки дублей контактов
            foreach ($ids as $contactId){
                $result = ContactDoubleHandler::run($contactId);
            }
        } elseif ($modelType == EntityTypesInterface::COMPANIES) {
            # обработка дублей компаний
            foreach ($ids as $companyId){
                #$result = CompanyDoubleHandler::run($companyId);
            }
        }
        # вернуть ответ
    }

}
