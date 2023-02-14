<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Collections\TagsCollection;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\TagModel;
use App\Models\Dto\Getcourse\DealDto;
use App\Services\AmoCRM\CustomFields\CreateCustomFieldsCollectionByDealDto;

class UpdateLeadModelByDealDto
{
    /**
     * @param LeadModel $lead
     * @param DealDto $deal
     * @return LeadModel
     */
    public static function run(LeadModel $lead, DealDto $deal): LeadModel
    {
        $custom_fields = CreateCustomFieldsCollectionByDealDto::run($deal);
        $lead->setCustomFieldsValues($custom_fields);
        if($deal->getCostMoney()){
            $lead->setPrice($deal->getCostMoney());
        }
        if($deal->getName()){
            $lead->setName(!empty($deal->getPositions()) ? $deal->getPositions() : $deal->getName());
        }
//        if($deal->getTag()){
//            $tags = $lead->getTags();
//            if( null === $tags) {
//                $tags = new TagsCollection();
//            }
//            $tag = new TagModel();
//            $tag->setName($deal->getTag());
//            $tags->add($tag);
//            $lead->setTags($tags);
//        }

        return $lead;
    }

}
