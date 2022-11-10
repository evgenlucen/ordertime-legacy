<?php


namespace App\Services\AmoCRM\Tag;


use AmoCRM\Collections\TagsCollection;
use AmoCRM\Models\TagModel;

class CreateTagsCollection
{

    /**
     * @param array $tags
     * @return TagsCollection
     */
    public static function run(array $tags)
    {
        $tag_collection = new TagsCollection();
        foreach ($tags as $tag) {
            $tag_model = new TagModel();
            $tag_model->setName($tag);
            $tag_collection->add($tag_model);
        }

        return $tag_collection;

    }
}