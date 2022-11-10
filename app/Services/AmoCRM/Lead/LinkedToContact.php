<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;

final class LinkedToContact
{

    /**
     * @param AmoCRMApiClient $api_client
     * @param LeadModel $lead_model
     * @param ContactModel $contact_model
     * @return LinksCollection|false
     */
    public static function run(AmoCRMApiClient $api_client, LeadModel $lead_model, ContactModel $contact_model)
    {
        $links = new LinksCollection();
        $links->add($contact_model);
        try {
            return $api_client->leads()->link($lead_model, $links);
        } catch (AmoCRMApiException $e) {
            return false;
        }
    }
}