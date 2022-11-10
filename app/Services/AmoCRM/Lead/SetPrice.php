<?php


namespace App\Services\AmoCRM\Lead;


use AmoCRM\Models\LeadModel;

class SetPrice
{
    public static function run(LeadModel $lead,$price)
    {
        if(!empty($price)){
            $lead->setPrice($price);
        }

        return $lead;
    }
}