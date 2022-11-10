<?php


namespace App\Services\Analytics\GoogleAnalytics\Tasks;


use App\Models\Dto\AmoCRM\LeadForAnalyticsDto;
use TheIconic\Tracking\GoogleAnalytics\Analytics;

class AddTransactionToAnalyticsDto
{
    public static function run(Analytics $analytics,LeadForAnalyticsDto $lead_dto)
    {
        $analytics
            ->setTransactionId($lead_dto->getLeadId())
            ->setRevenue($lead_dto->getRevenue());

        if (!empty($lead_dto->getProductName())) {
            $productData = [
                'name' => $lead_dto->getProductName(),
                'price' => $lead_dto->getRevenue(),
                'quantity' => 1
            ];
            $analytics->addProduct($productData);
        }

        $analytics->setProductActionToPurchase();

        return $analytics;

    }

}