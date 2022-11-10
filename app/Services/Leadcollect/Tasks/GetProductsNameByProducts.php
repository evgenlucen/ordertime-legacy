<?php


namespace App\Services\Leadcollect\Tasks;


class GetProductsNameByProducts
{
    /**
     * @param array $products
     * @return array
     */
    public static function run(array $products)
    {
        $products_name = [];
        foreach ($products as $product){
            $products_name[] = $product['name'];
        }

        return $products_name;
    }

}