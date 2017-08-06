<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 8/5/17
 * Time: 6:50 PM
 */

namespace TestPagarme\Model;


use TestPagarme\Entity\ShoppingCartEntity;
use TestPagarme\Helper\ShoppingCartSource;

class ShoppingCart
{
    /**
     * @var ShoppingCartEntity $shoppingCardEntity
     */
    private $shoppingCardEntity;

    public function create(ShoppingCartEntity $shoppingCartEntity) {
        return ShoppingCartSource::setResource(null, $shoppingCartEntity->__toArray());
    }
}