<?php

namespace App\Services\AmoCRM\Helper;

use AmoCRM\Collections\BaseApiCollection;

class GetUniqModelIdsByCollection
{
    public static function run(BaseApiCollection $collection): array
    {
        $modelIds = $collection->pluck('id');
        return array_unique($modelIds, SORT_NUMERIC);
    }
}
