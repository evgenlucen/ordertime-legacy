<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Models\LeadModel;

final class FindLeadsByQuery
{
    /**
     * @param AmoCRMApiClient $api_client
     * @param string $query
     * @return \AmoCRM\Collections\Leads\LeadsCollection|null
     * @throws \Exception
     */
    public static function run(AmoCRMApiClient $api_client, string $query)
    {
        if (strlen($query) < 3) {
            throw new \Exception('Слишком короткий запрос для поиска - ' . $query);
        }
        $lead_filter = new LeadsFilter();
        $lead_filter->setQuery($query);

        try {
            $lead_collection = $api_client->leads()->get($lead_filter, [LeadModel::CONTACTS]);
        } catch (AmoCRMApiException $e) {
            return new LeadsCollection();
        }

        return $lead_collection;
    }

}