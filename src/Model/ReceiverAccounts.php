<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/30/17
 * Time: 7:35 PM
 */

namespace TestPagarme\Model;


use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\PagarMe;
use TestPagarme\Helper\DataSource;
use TestPagarme\Helper\PagarmeInfoHandler;

class ReceiverAccounts
{
    public function create(PagarmeInfoHandler $pagarmeInfoHandler) {

        $receiverInfo = self::getReceiverInfo();

        try {
            foreach ($receiverInfo as $receiverKey => $receiverValue) {
                $receiverInfoPagarme = self::sendReceiverInfoToPagarme($receiverValue, $pagarmeInfoHandler);

                DataSource::setResource("$receiverKey.receiverInfo.id", $receiverInfoPagarme->getId());
            }
        } catch (\Exception $e) {
            throw new \ErrorException('Ocorreu um erro na gravação dos dados do recebedor tente novamente mais tarde', 1, __FILE__, __LINE__);
        }
    }

    private function sendReceiverInfoToPagarme($infoValue, PagarmeInfoHandler $pagarmeInfoHandler) {


        $pagarMe = new PagarMe($pagarmeInfoHandler->getApiKey());

        $bankAccount = new BankAccount([
            "id" => $infoValue->bank_account_id
        ]);

        return $pagarMe->recipient()->create(
            $bankAccount,
            $infoValue->transfer_interval,
            $infoValue->transfer_day,
            $infoValue->transfer_enabled,
            $infoValue->automatic_anticipation_enabled,
            $infoValue->anticipatable_volume_percentage
        );
    }

    public static function getReceiverInfo() {
        return DataSource::getResources('*.receiverInfo');
    }
}