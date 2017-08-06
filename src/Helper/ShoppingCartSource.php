<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 8/5/17
 * Time: 8:07 PM
 */

namespace TestPagarme\Helper;


class ShoppingCartSource extends DataSource
{
    public static function getResources($resources = null, $sourceFile = __DIR__ . '/../dataSource/shoppingCart.json') {
        return parent::getResources($resources, $sourceFile);
    }

    public static function setResource($resources = null, $value, $sourceFile = __DIR__ . '/../dataSource/shoppingCart.json')
    {
        return parent::setResource($resources, $value, $sourceFile);
    }
}