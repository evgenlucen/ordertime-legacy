<?php

namespace App\Services\AmoCRM\Task;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\TaskModel;

class CreateDoubleTask
{
    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     */
    public static function contact(
        AmoCRMApiClient $apiClient,
        string $query,
        int $entityId,
        int $taskType
    ): TaskModel
    {

        $accountDomain = $apiClient->getAccountBaseDomain();

        $textTask = sprintf(
            "Найден дубль контакта: https://%s.amocrm.ru/contacts/list/contacts/?term=%s",
            $accountDomain,
            $query
        );

        $taskModel = new TaskModel();
        $taskModel->setText($textTask);
        $taskModel->setEntityId($entityId);
        $taskModel->setEntityType(EntityTypesInterface::CONTACTS);
        $taskModel->setCompleteTill((new \DateTimeImmutable())->getTimestamp() + 24*60*60);
        $taskModel->setTaskTypeId($taskType);

        return $apiClient->tasks()->addOne($taskModel);
    }

    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     */
    public static function lead(
        AmoCRMApiClient $apiClient,
        string $query,
        int $entityId,
        int $taskType
    ): TaskModel
    {

        $accountDomain = $apiClient->getAccountBaseDomain();

        $textTask = sprintf(
            "Найден дубль сделки: https://%s.amocrm.ru/leads/list/?term=%s",
            $accountDomain,
            $query
        );

        $taskModel = new TaskModel();
        $taskModel->setText($textTask);
        $taskModel->setEntityId($entityId);
        $taskModel->setEntityType(EntityTypesInterface::LEADS);
        $taskModel->setCompleteTill((new \DateTimeImmutable())->getTimestamp() + 24*60*60);
        $taskModel->setTaskTypeId($taskType);

        return $apiClient->tasks()->addOne($taskModel);
    }

}
