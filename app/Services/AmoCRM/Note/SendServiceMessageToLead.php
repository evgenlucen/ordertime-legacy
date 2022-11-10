<?php


namespace App\Services\AmoCRM\Note;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\NoteType\ServiceMessageNote;
use App\Configs\amocrmConfig;

class SendServiceMessageToLead
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param string $text
     * @param int $lead_id
     * @return AmoCRMApiException|\Exception
     */
    public static function run(AmoCRMApiClient $api_client, string $text,int $lead_id)
    {
        $note_model = new ServiceMessageNote();
        $note_model->setText($text);
        $note_model->setService(amocrmConfig::NAME_SERVICE_MESSAGE);
        $note_model->setEntityId($lead_id);
        try {
            $result = $api_client->notes(EntityTypesInterface::LEADS)->addOne($note_model);
        } catch (AmoCRMApiException $e) {
            return $e;
        }
    }

}