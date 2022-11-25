<?php

namespace App\Services\AmoCRM\Helper;

use AmoCRM\Collections\BaseApiCollection;
use Exception;

class MergeCollections
{
    /**
     * @throws Exception
     */
    public static function run(BaseApiCollection $firstCollection, BaseApiCollection $secondCollection): BaseApiCollection
    {
        if(get_class($firstCollection) !== get_class($secondCollection)) {
            throw new Exception("collections must be of the same class");
        }
        for ($i = 0; $i < $secondCollection->count(); $i++){
            $contact = $secondCollection->offsetGet($i);
            $firstCollection->add($contact);
        }

        return $firstCollection;
    }

}
