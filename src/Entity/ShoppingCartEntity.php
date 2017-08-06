<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 8/5/17
 * Time: 6:54 PM
 */

namespace TestPagarme\Entity;


class ShoppingCartEntity
{
    /**
     * Id do carrinho feito com base no arquivo {ROOT}/src/dataSource/shoppingCart.json
     * @var int $cartId
     */
    private $cartId;

    /**
     * Array de produtos que estão no carrinho
     * @var [ProductEntity] $products
     */
    private $products;

    /**
     * @var float $totalShoppingCart
     */
    private $totalShoppingCart;

    /**
     * @return int
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * @param int $cartId
     * @return ShoppingCartEntity
     */
    public function setCartId($cartId)
    {
        $this->cartId = $cartId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     * @return ShoppingCartEntity
     */
    public function setProducts( array $products)
    {
        $this->products = $products;
        return $this;
    }

    public function getProductsArray() {
        $productArray = [];
        $totalCart = 0;

        /**
         * @var ProductEntity $product
         */
        foreach ($this->products as $product) {
            array_push($productArray, $product->__toArray());

            $totalCart += $product->getTotal();
        }

        $this->totalShoppingCart = $totalCart;

        return $productArray;
    }

    public function __toArray(){

        return [
            'products' => self::getProductsArray(),
            'totalCart' => $this->totalShoppingCart
        ];
    }
}