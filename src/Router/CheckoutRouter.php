<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/30/17
 * Time: 3:42 PM
 */

namespace TestPagarme\Router;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class CheckoutRouter implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $routeFactory = $app['controllers_factory'];

        $routeFactory->get('/', 'TestPagarme\Controller\CheckoutController::checkoutAction')->bind('checkout');
        $routeFactory->get('/saveShoppingCart', 'TestPagarme\Controller\CheckoutController::saveShoppingCartAction')->bind('saveShoppingCart');

        return $routeFactory;
    }
}