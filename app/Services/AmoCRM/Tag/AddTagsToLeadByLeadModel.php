<?php

namespace App\Services\AmoCRM\Tag;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\TagModel;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AddTagsToLeadByLeadModel
{

    /**
     * @param AmoCRMApiClient $api_client
     * @param LeadModel $lead_model
     * @param array $tags
     * @return LeadModel
     * @throws \Exception
     */
    public static function run(AmoCRMApiClient $api_client, LeadModel $lead_model, array $tags): LeadModel
    {
        $tags_collection = AppendTagsToTagsCollection::run($lead_model, $tags);
        $lead_model->setTags($tags_collection);

        try {
            $result = $api_client->leads()->updateOne($lead_model);
        } catch (AmoCRMMissedTokenException|AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            throw new \Exception($e->getMessage());
        }

        return $result;

    }

}
