<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\LeadModel;
use App\Models\Dto\Getcourse\UserDto;
use App\Services\AmoCRM\CustomFields\CreateCustomFieldsCollectionByArray;

class UpdateLeadModelByUserDto
{
    /**
     * @param LeadModel $lead
     * @param UserDto $user
     * @return LeadModel
     * @throws \AmoCRM\Exceptions\InvalidArgumentException
     */
    public static function run(LeadModel $lead,UserDto $user)
    {
        $custom_fields = CreateCustomFieldsCollectionByArray::run($user->toArray(),EntityTypesInterface::LEAD);
        $lead->setCustomFieldsValues($custom_fields);
        return $lead;
    }

}