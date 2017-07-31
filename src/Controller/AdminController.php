<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 11:07 AM
 */

namespace TestPagarme\Controller;


use Silex\Application;
use TestPagarme\Helper\DataSource;
use TestPagarme\Helper\PagarmeInfoHandler;
use TestPagarme\Model\BankAccounts;
use TestPagarme\Model\ReceiverAccounts;

class AdminController
{
    /**
     * @param Application $app
     * @return Response
     */
    public function adminAction(Application $app) {
        $bankAccounts = (array) BankAccounts::getBankInfo();

        return $app['twig']->render('admin/admin.html.twig', ['bankAccounts' => $bankAccounts]);
    }

    public function createBankAccountsAction(Application $app) {
        try {
            $bankAccounts = new BankAccounts();
            $bankAccounts->create(new PagarmeInfoHandler());
        } catch (\ErrorException $e) {
            if ($e->getCode() == 1) {
                $app['session']->getFlashBag()->add('warning', $e->getMessage());
            } else {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        }

        return $app->redirect($app['url_generator']->generate('admin'));
    }

    public function createReceiverAccountAction(Application $app) {
        try {
            $receiverAccounts = new ReceiverAccounts();
            $receiverAccounts->create(new PagarmeInfoHandler());
        } catch (\ErrorException $e) {
            if ($e->getCode() == 1) {
                $app['session']->getFlashBag()->add('warning', $e->getMessage());
            } else {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        }

        return $app->redirect($app['url_generator']->generate('admin'));
    }
}