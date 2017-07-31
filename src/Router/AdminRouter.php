<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/30/17
 * Time: 4:03 PM
 */

namespace TestPagarme\Router;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class AdminRouter implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $routeFactory = $app['controllers_factory'];

        $routeFactory->get('/', 'TestPagarme\Controller\AdminController::adminAction')->bind('admin');
        $routeFactory->post('/bankAccount', 'TestPagarme\Controller\AdminController::createBankAccountsAction')->bind('createBankAccount');
        $routeFactory->post('/receiverAccount', 'TestPagarme\Controller\AdminController::createReceiverAccountAction')->bind('createReceiverAccount');

        return $routeFactory;
    }
}