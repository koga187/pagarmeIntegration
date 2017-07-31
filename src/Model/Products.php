<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/30/17
 * Time: 9:57 PM
 */

namespace TestPagarme\Model;


use TestPagarme\Helper\DataSource;

class Products
{
    public static function getProducts() {
        $allresources = DataSource::getResources('*');

        return self::parseResourceToProducts($allresources);
    }

    public static function parseResourceToProducts($allResources) {
        $products = [];
        foreach ($allResources as $keyResource => $resource) {
            $products[$keyResource] = [
                'description' => $resource->description,
                'price' => $resource->price,
                'productOwner' => $resource->productOwner
            ];
            $products['total'] += $resource->price;
        }

        return $products;
    }
}