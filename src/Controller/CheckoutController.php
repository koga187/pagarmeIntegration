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
use TestPagarme\Model\Products;

class CheckoutController
{
    /**
     * @param Application $app
     * @return Response
     */
    public function checkoutAction(Application $app)
    {
        $products = Products::getProducts();
        $total = $products['total'];
        unset($products['total']);
        return $app['twig']->render('checkout/checkout.html.twig', [
            'products' => $products,
            'total' => $total
        ]);
    }

    public function saveShoppingCartAction(Application $app, Request $request) {

    }

    public function paymentDataAction(Application $app) {

    }
}