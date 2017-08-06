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
use TestPagarme\Entity\CheckoutEntity;
use TestPagarme\Helper\DataSource;
use TestPagarme\Helper\PagarmeInfoHandler;
use TestPagarme\Helper\ShoppingCartSource;
use TestPagarme\Model\BankAccounts;
use TestPagarme\Model\Checkout;
use TestPagarme\Model\Products;
use TestPagarme\Model\Receiver;

class CheckoutController
{
    /**
     * @param Application $app
     * @return Response
     */
    public function checkoutAction(Application $app, Request $request)
    {
        $shoppingCart = [];
        try {
            $shoppingCart = ShoppingCartSource::getResources();
        } catch (\Exception $e) {
            if ($e->getCode() == 1) {
                $app['session']->getFlashBag()->add('warning', $e->getMessage());
            } else {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        } finally {
            return $app['twig']->render('checkout/checkout.html.twig', [
                'shoppingCart' => $shoppingCart
            ]);
        }
    }

    public function saveShoppingCartAction(Application $app, Request $request) {
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
    }

    public function paymentAction(Application $app, Request $request) {

        $checkoutEntity = (new CheckoutEntity())->setCustomerEmail($request->request->get('customer_email'))
            ->setCustomerName($request->request->get('customer_name'))
            ->setCustomerDocument($request->request->get('customer_document'))
            ->setCustomerPhone($request->request->get('customer_phone_number'))
            ->setAddressZipCode($request->request->get('address_zipcode'))
            ->setAddressNeighborhood($request->request->get('address_neighborhood'))
            ->setAddessStreet($request->request->get('address_street'))
            ->setAddressNumber($request->request->get('address_street_number'))
            ->setAddressCity($request->request->get('address_city'))
            ->setAddressState($request->request->get('address_state'))
            ->setCardName($request->request->get('card_name'))
            ->setCardNumber($request->request->get('card_number'))
            ->setCardExpireDate($request->request->get('card_expire'))
            ->setCardCvv($request->request->get('card_cvv'));

        try {
            $receiverInfo = DataSource::getResources(null);
            $shoppingCartData = ShoppingCartSource::getResources(null);
            $receivers = Receiver::calcPercentFromReceiver($receiverInfo, $shoppingCartData);
            $checkoutEntity->setTotal($receivers['total']);

            $transaction = Checkout::payment(new PagarmeInfoHandler(), $checkoutEntity, $receivers);

            $app['session']->getFlashBag()->add('success', 'Pagamento efetuado com sucesso!' . $transaction->getId());
        } catch (\Exception $e) {
            if ($e->getCode() == 1) {
                $app['session']->getFlashBag()->add('warning', $e->getMessage());
            } else {
                $app['session']->getFlashBag()->add('danger', $e->getMessage());
            }
        } finally {
            if (isset($e)) {
                return $app->redirect($app['url_generator']->generate('checkout'), 302);
            }

            return $app->redirect($app['url_generator']->generate('index'), 302);
        }
    }
}