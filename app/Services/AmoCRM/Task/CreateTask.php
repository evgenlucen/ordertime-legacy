<?php

namespace App\Services\AmoCRM\Task;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\TaskModel;
use function Psy\debug;

class CreateTask
{
    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     */
    public static function contact(
        AmoCRMApiClient $apiClient,
        string $text,
        int $entityId,
        int $taskType,
        int $hours
    ): TaskModel
    {

        $textTask = sprintf(
            "%s",
            $text
        );

        $taskModel = new TaskModel();
        $taskModel->setText($textTask);
        $taskModel->setEntityId($entityId);
        $taskModel->setEntityType(EntityTypesInterface::CONTACTS);
        $taskModel->setCompleteTill((new \DateTimeImmutable())->getTimestamp() + $hours*60*60);
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
        string $text,
        int $entityId,
        int $taskType,
        int $hours
    ): TaskModel
    {
        $textTask = sprintf(
            "%s",
            $text
        );

        $taskModel = new TaskModel();
        $taskModel->setText($textTask);
        $taskModel->setEntityId($entityId);
        $taskModel->setEntityType(EntityTypesInterface::LEADS);
        $taskModel->setCompleteTill((new \DateTimeImmutable())->getTimestamp() + $hours*60*60);
        $taskModel->setTaskTypeId($taskType);

        return $apiClient->tasks()->addOne($taskModel);
    }

}
