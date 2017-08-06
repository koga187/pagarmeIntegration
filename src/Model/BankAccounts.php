<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/30/17
 * Time: 4:07 PM
 */

namespace TestPagarme\Model;


use PagarMe\Sdk\PagarMe;
use TestPagarme\Helper\DataSource;
use TestPagarme\Helper\PagarmeInfoHandler;

class BankAccounts
{
    public function create(PagarmeInfoHandler $pagarmeInfoHandler) {

        $bankInfo = self::getBankInfo();

        try {

            foreach ($bankInfo as $infoKey => $infoValue) {
                $bankInfoPagarme = self::sendBankInfoToPagarme($infoValue->bankInfo, $pagarmeInfoHandler);

                DataSource::setResource("$infoKey.bankInfo.id", $bankInfoPagarme->getId());
                DataSource::setResource("$infoKey.receiverInfo.bank_account_id", $bankInfoPagarme->getId());
            }
        } catch (\Exception $e) {
            exit('<pre>' . print_r($e, true));
            throw new \ErrorException('Ocorreu um erro na gravação dos dados bancarios tente novamente mais tarde', 1, __FILE__, __LINE__);
        }
    }

    public static function getBankInfo() {
        return DataSource::getResources('*');
    }

    private function sendBankInfoToPagarme($bankInfo, PagarmeInfoHandler $pagarmeInfoHandler) {

        $pagarMe = new PagarMe($pagarmeInfoHandler->getApiKey());

        return $pagarMe->bankAccount()->create(
            $bankInfo->bank_code,
            $bankInfo->agencia,
            $bankInfo->conta,
            $bankInfo->conta_dv,
            $bankInfo->document_number,
            $bankInfo->legal_name,
            $bankInfo->agencia_dv
        );
    }
}