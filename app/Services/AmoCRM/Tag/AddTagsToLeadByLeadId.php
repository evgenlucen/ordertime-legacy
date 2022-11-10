<?php

namespace App\Services\AmoCRM\Tag;




use AmoCRM\Client\AmoCRMApiClient;
use App\Services\AmoCRM\Lead\GetLeadById;

final class AddTagsToLeadByLeadId
{

    public static function run(AmoCRMApiClient $api_client, int $lead_id, array $tags)
    {
        $lead = GetLeadById::run($api_client,$lead_id);
        $tags_collection = AppendTagsToTagsCollection::run($lead,$tags);
        $lead->setTags($tags_collection);

        try {
            $result = $api_client->leads()->updateOne($lead);
        } catch (\AmoCRM\Exceptions\AmoCRMMissedTokenException $e) {
        } catch (\AmoCRM\Exceptions\AmoCRMoAuthApiException $e) {
        } catch (\AmoCRM\Exceptions\AmoCRMApiException $e) {
            return false;
        }

        return $result;
    }

}