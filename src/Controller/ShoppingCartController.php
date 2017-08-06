<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 11:07 AM
 */

namespace TestPagarme\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use TestPagarme\Entity\ProductEntity;
use TestPagarme\Entity\ShoppingCartEntity;
use TestPagarme\Model\Products;
use TestPagarme\Model\Receiver;
use TestPagarme\Model\ShoppingCart;

class shoppingCartController
{
    /**
     * @param Application $app
     * @return Response
     */
    public function shoppingCartAction(Application $app)
    {
        $products = Products::getProducts();
        $total = $products['total'];
        unset($products['total']);
        return $app['twig']->render('shoppingCart/shoppingCart.html.twig', [
            'products' => $products,
            'total' => $total,
            'frete' => Receiver::$frete
        ]);
    }

    public function saveShoppingCartAction(Application $app, Request $request) {
        $arrayProducts = [];
        $payload = $request->request->all();
        foreach ($payload['codigo'] as $productCode) {
            $arrayProducts[$productCode] = (isset($arrayProducts[$productCode]) && is_object($arrayProducts[$productCode])) ? $arrayProducts[$productCode] : new ProductEntity();
            /**
             * @var [ProductEntity] $arrayProducts
             */
            $arrayProducts[$productCode]->setId($productCode)
                ->setQuantity($payload['quantidade'][$productCode])
                ->setValue($payload['valor'][$productCode]);
        }

        $shoppingCart = (new ShoppingCartEntity())->setProducts($arrayProducts);

        try {
            (new ShoppingCart())->create($shoppingCart);
        } catch (\ErrorException $e) {
            if ($e->getCode() == 1) {
                $app['session']->getFlashBag()->add('warning', $e->getMessage());
            } else {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        } finally {
            return $app->redirect($app['url_generator']->generate('checkout'), 302);
        }
    }
}