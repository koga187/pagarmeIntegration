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
        $routeFactory->post('/payment', 'TestPagarme\Controller\CheckoutController::paymentAction')->bind('payment');

        return $routeFactory;
    }
}