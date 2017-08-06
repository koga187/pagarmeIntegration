<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/30/17
 * Time: 9:57 PM
 */

namespace TestPagarme\Model;


use PagarMe\Sdk\Customer\Address;
use PagarMe\Sdk\Customer\Customer;
use PagarMe\Sdk\Customer\Phone;
use PagarMe\Sdk\PagarMe;
use PagarMe\Sdk\SplitRule\SplitRuleCollection;
use TestPagarme\Entity\CheckoutEntity;
use TestPagarme\Entity\ReceiverEntity;
use TestPagarme\Helper\PagarmeInfoHandler;

class Checkout
{
    /**
     * @param PagarmeInfoHandler $pagarmeInfoHandler
     * @param CheckoutEntity $checkoutEntity
     * @param [] $recipients
     * @return \PagarMe\Sdk\Transaction\CreditCardTransaction
     */
    public static function payment(PagarmeInfoHandler $pagarmeInfoHandler, CheckoutEntity $checkoutEntity, array $receivers) {
        $pagarMe = new PagarMe($pagarmeInfoHandler->getApiKey());

        /**
         * parcelas
         */
        $installments = 1;
        $capture = true;
        $postbackUrl = 'http://requestb.in/pkt7pgpk';
        $metadata = ['idProduto' => 13933139];
        /**
         * dados da transaçao do meu checkout
         */

        //TRANSAÇÃO DE CARTÃO DE CRÉDITO
        $customer = new Customer(
            [
                'name' => $checkoutEntity->getCustomerName(),
                'email' => $checkoutEntity->getCustomerEmail(),
                'document_number' => $checkoutEntity->getCustomerDocument(),
                'address' => new Address([
                    'street'        => $checkoutEntity->getAddessStreet(),
                    'street_number' => $checkoutEntity->getAddressNumber(),
                    'neighborhood'  => $checkoutEntity->getAddressNeighborhood(),
                    'zipcode'       => $checkoutEntity->getAddressZipCode(),
                    'complementary' => '',
                    'city'          => $checkoutEntity->getAddressCity(),
                    'state'         => $checkoutEntity->getAddressState(),
                    'country'       => 'brasil'
                ]),
                'phone' => new Phone([
                    'ddd'    => $checkoutEntity->getCustomerPhoneDDD(),
                    'number' => $checkoutEntity->getCustomerPhone()
                ]),
                'born_at' => '15021994',
                'sex' => 'M'
            ]
        );

        $card = $pagarMe->card()->create(
            $checkoutEntity->getCardNumber(),
            $checkoutEntity->getCardName(),
            $checkoutEntity->getCardExpireDate()
        );

        $splitRules = self::getSplitRules($pagarMe, $receivers);

        return $pagarMe->transaction()->creditCardTransaction(
            $checkoutEntity->getTotal(),
            $card,
            $customer,
            $installments,
            $capture,
            $postbackUrl,
            $metadata,
            ["split_rules" => $splitRules]
        );
    }

    public static function getSplitRules(Pagarme $pagarMe, $receivers) {
        /**
         * @var ReceiverEntity $receiver
         */
        $splitRule = new SplitRuleCollection();
        foreach ($receivers as $key =>  $receiver) {
            if (is_object($receiver)) {
                $recipient = $pagarMe->recipient()->get($receiver->getId());

                $splitRule[$key] = $pagarMe->splitRule()->monetaryRule(
                    $receiver->getAmount(),
                    $recipient,
                    true,
                    true,
                    true
                );
            }
        }

        return $splitRule;
    }
}