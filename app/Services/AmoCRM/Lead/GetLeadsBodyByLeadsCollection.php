<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Filters\LeadsFilter;

class GetLeadsBodyByLeadsCollection
{
    public static function run(AmoCRMApiClient $api_client,LeadsCollection $leads_collection)
    {
        $filter = new LeadsFilter();
        $filter->setIds(GetLeadsIdByLeadsCollection::run($leads_collection));

        try {
            $leads_collection = $api_client->leads()->get($filter);
        } catch (AmoCRMMissedTokenException $e) {
        } catch (AmoCRMoAuthApiException $e) {
        } catch (AmoCRMApiException $e) {
            return new LeadsCollection();
        }

        return $leads_collection;
    }

}