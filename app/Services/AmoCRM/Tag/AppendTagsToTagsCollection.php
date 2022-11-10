<?php


namespace App\Services\AmoCRM\Tag;


use AmoCRM\Collections\TagsCollection;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\TagModel;

class AppendTagsToTagsCollection
{
    /**
     * @param LeadModel $lead_model
     * @param array $tags
     * @return TagsCollection
     */
    public static function run(LeadModel $lead_model, array $tags)
    {
        $tags_collection = $lead_model->getTags();
        if (!empty($tags_collection)) {
            foreach ($tags as $tag) {
                $tag_model = new TagModel();
                $tag_model->setName($tag);
                $tags_collection->add($tag_model);
            }
        } else {
            return CreateTagsCollection::run($tags);
        }
        return $tags_collection;
    }

}