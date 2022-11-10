<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Collections\TagsCollection;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\TagModel;
use App\Configs\amocrmConfig;
use App\Models\Dto\LeadCollect\LcModel;
use App\Services\AmoCRM\CustomFields\CreateCustomFieldsCollectionByLeadCollectModel;
use App\Services\AmoCRM\Tag\CreateTagsCollection;

class UpdateLeadModelByLeadCollectionModel
{
    public static function run(LeadModel $lead,LcModel $lc_model)
    {
        if(!empty($lc_model->getLtype())) { $lead->setName($lc_model->getLtype()); }
        $cf_map_name_id = amocrmConfig::getCfNameIdMapLead();
        $custom_fields = CreateCustomFieldsCollectionByLeadCollectModel::run($lc_model,$cf_map_name_id);
        $lead->setCustomFieldsValues($custom_fields);
        if(!empty($lc_model->getTags())){
            $tags = CreateTagsCollection::run($lc_model->getTags());
            $lead->setTags($tags);
        }

        return $lead;
    }

}