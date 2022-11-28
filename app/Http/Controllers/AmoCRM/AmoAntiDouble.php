<?php

namespace App\Http\Controllers\AmoCRM;


use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Helpers\EntityTypesInterface;
use App\Services\AmoCRM\Double\ContactDoubleHandler;
use App\Services\AmoCRM\Webhook\GetModelIdsByWebhook;
use App\Services\AmoCRM\Webhook\GetModelTypeByWebhook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use function Psy\debug;

class AmoAntiDouble extends Controller
{
    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     */
    public function run(Request $request): JsonResponse
    {
        # TODO List
        # Получить тип вебхука (создание сделки, удаление неразобранного, создание контакта)
        $modelType = GetModelTypeByWebhook::run($request);
        $ids = GetModelIdsByWebhook::run($request,$modelType);

        # Передать id сущности для обработки в специализированный для сущности сервис
        if ($modelType === EntityTypesInterface::LEADS){

            # сервис обработки дублей для сделок
//            foreach ($ids as $leadId){
//                #$result = LeadDoubleHandler::run($leadId);
//            }

        } elseif ($modelType === EntityTypesInterface::CONTACT){
            # сервис обработки дублей контактов
            foreach ($ids as $contactId){
                $result = ContactDoubleHandler::run($contactId);
            }
        } elseif ($modelType == EntityTypesInterface::COMPANIES) {
            # обработка дублей компаний
//            foreach ($ids as $companyId){
//                #$result = CompanyDoubleHandler::run($companyId);
//            }
        } else {
            throw new \Exception("Not supported model type" . (string)$modelType);
        }
        # вернуть ответ
        return new JsonResponse([
            'success' => true,
            'data' => [
                'model_type' => $modelType,
                'ids' => $ids,
                'result' => $result
            ]
        ]);
    }

}
