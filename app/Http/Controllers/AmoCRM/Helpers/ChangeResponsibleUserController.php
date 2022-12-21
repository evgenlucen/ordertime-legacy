<?php

namespace App\Http\Controllers\AmoCRM\Helpers;


use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;
use App\Http\Controllers\Controller;
use App\Services\AmoCRM\ApiClient\GetApiClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Webmozart\Assert\Assert;

class ChangeResponsibleUserController extends Controller
{
    /**
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     */
    public static function run(Request $request): JsonResponse
    {
        $amoLeadId = $request->input('amo_lead_id') ?? null;
        Assert::notEmpty($amoLeadId, "undefined amo_lead_id");

        $amoContactId = $request->input('amo_contact_id') ?? null;

        $responsibleUserId = $request->input('responsible_user_id');
        Assert::notEmpty($responsibleUserId, "undefined responsible_user_id");

        $lead = new LeadModel();
        $lead->setResponsibleUserId($responsibleUserId);
        $lead->setId($amoLeadId);

        if (null !== $amoContactId) {
            $contact = new ContactModel();
            $contact->setResponsibleUserId($responsibleUserId);
            $contact->setId($amoContactId);
        }


        $amoApiClient = GetApiClient::getApiClient();
        $resultLeadUpdate = $amoApiClient->contacts()->updateOne($contact);

        if (isset($contact)) {
            $resultContactUpdate = $amoApiClient->leads()->updateOne($lead);
            $dataLog[] = ['contactUpdate' => $resultContactUpdate->getId()];
        }

        $dataLog[] = ['leadUpdate' => $resultLeadUpdate->getId()];

        return new JsonResponse([
            'success' => true,
            'data' => [
                $dataLog
            ]
        ]);

    }

}
