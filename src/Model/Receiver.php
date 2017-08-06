<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 8/6/17
 * Time: 12:16 PM
 */

namespace TestPagarme\Model;


use TestPagarme\Entity\ReceiverEntity;

class Receiver
{
    private static $frete = 42.00;

    public static function calcPercentFromReceiver(\stdClass $receiverInfo, \stdClass $shoppingCartData): array {
        $receiverAmount = [];
        $codMktPlaceOwner = 0;
        $totalCartWithFrete = 0;

        foreach ($receiverInfo as $codReceiver => $receiver) {
            $receiverAmount[$codReceiver] = (isset($receiverAmount[$codReceiver]) && is_object($receiverAmount[$codReceiver])) ?
                $receiverAmount[$codReceiver] : (new ReceiverEntity())->setId($receiver->receiverInfo->id);

            $codMktPlaceOwner = ($receiver->receiverInfo->productOwner == true) ? $codReceiver : $codMktPlaceOwner;

            $amount = ($receiver->receiverInfo->productOwner == true) ?
                self::calcOwnerAmount($shoppingCartData->products[$codReceiver]) : self::calcPartnersAmount($shoppingCartData->products[$codReceiver]);

            if (!is_array($amount)) {
                $receiverAmount[$codReceiver]->addAmount($amount);

                $totalCartWithFrete += $amount;
            } else {
                $receiverAmount[$codMktPlaceOwner]->addAmount($amount['MktPlaceOwner']);
                $receiverAmount[$codReceiver]->addAmount($amount['costumesOwner']);
                $totalCartWithFrete += $amount['MktPlaceOwner'] + $amount['costumesOwner'];
            }
        }
        $receiverAmount['total'] = $totalCartWithFrete;

        return $receiverAmount;
    }

    private static function calcOwnerAmount($shoppingCartData) {
        return floatval($shoppingCartData->quantity) * floatval($shoppingCartData->value) + (floatval($shoppingCartData->quantity) * floatval(self::$frete));
    }

    private static function calcPartnersAmount($shoppingCartData) {
        $frete = (floatval($shoppingCartData->quantity) * floatval(self::$frete));
        $totalTranssaction = floatval($shoppingCartData->quantity) * floatval($shoppingCartData->value);

        return [
            'MktPlaceOwner' => $totalTranssaction * 0.15,
            'costumesOwner' => $totalTranssaction * 0.85 + $frete,
            'total' => $totalTranssaction + $frete
        ];
    }
}