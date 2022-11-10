<?php


namespace App\Services\AmoCRM\Note;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Exceptions\InvalidArgumentException;
use AmoCRM\Models\NoteModel;
use AmoCRM\Models\NoteType\CommonNote;
use App\Services\Logger\Logger;

class AddTextNoteToEntity
{

    /**
     * @param AmoCRMApiClient $api_client
     * @param int $entity_id
     * @param string $entity_type
     * @param string $text
     * @return NoteModel|bool
     */
    public static function run(AmoCRMApiClient $api_client,
                               int $entity_id,
                               string $entity_type,
                               string $text
                            )
    {

        $note = new CommonNote();
        $note->setEntityId($entity_id);
        $note->setText($text);

        try {
            return $api_client->notes($entity_type)->addOne($note);
        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (InvalidArgumentException $e) {
        } catch (AmoCRMApiException $e) {
            return $e->getMessage();
        }
    }

}