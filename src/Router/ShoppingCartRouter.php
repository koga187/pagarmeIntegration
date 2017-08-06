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

class ShoppingCartRouter implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $routeFactory = $app['controllers_factory'];

        $routeFactory->get('/', 'TestPagarme\Controller\ShoppingCartController::shoppingCartAction')->bind('shoppingCart');
        $routeFactory->post('/saveShoppingCart', 'TestPagarme\Controller\ShoppingCartController::saveShoppingCartAction')->bind('saveShoppingCart');

        return $routeFactory;
    }
}