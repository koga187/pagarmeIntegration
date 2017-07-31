<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 11:10 AM
 */

namespace TestPagarme\Router;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class IndexRouter implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $routeFactory = $app['controllers_factory'];

        $routeFactory->get('/', 'TestPagarme\Controller\IndexController::indexAction')->bind('index');

        return $routeFactory;
    }
}