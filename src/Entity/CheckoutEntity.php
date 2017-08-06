<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 8/5/17
 * Time: 11:10 PM
 */

namespace TestPagarme\Entity;


class CheckoutEntity
{
    private $customerName;

    private $customerEmail;

    private $customerDocument;

    private $customerPhone;

    private $customerPhoneDDD;

    private $addressZipCode;

    private $addressNeighborhood;

    private $addessStreet;

    private $addressNumber;

    private $addressCity;

    private $addressState;

    private $cardName;

    private $cardNumber;

    private $cardExpireDate;

    private $cardCvv;

    private $total;

    /**
     * @return mixed
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param mixed $customerName
     * @return CheckoutEntity
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @param mixed $customerEmail
     * @return CheckoutEntity
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerDocument()
    {
        return $this->customerDocument;
    }

    /**
     * @param mixed $customerDocument
     * @return CheckoutEntity
     */
    public function setCustomerDocument($customerDocument)
    {
        $this->customerDocument = preg_replace('/\D/', '', $customerDocument);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerPhone()
    {
        return $this->customerPhone;
    }

    /**
     * @param mixed $customerPhone
     * @return CheckoutEntity
     */
    public function setCustomerPhone($customerPhone)
    {
        preg_match('/\(([0-9]{2})\)/', $customerPhone, $ddd);
        $this->setCustomerPhoneDDD($ddd[1]);
        $number = substr(preg_replace('/\D/', '', $customerPhone), 2);

        $this->customerPhone = $number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerPhoneDDD()
    {
        return $this->customerPhoneDDD;
    }

    /**
     * @param mixed $customerPhoneDDD
     * @return CheckoutEntity
     */
    public function setCustomerPhoneDDD($customerPhoneDDD)
    {
        $this->customerPhoneDDD = $customerPhoneDDD;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressZipCode()
    {
        return $this->addressZipCode;
    }

    /**
     * @param mixed $addressZipCode
     * @return CheckoutEntity
     */
    public function setAddressZipCode($addressZipCode)
    {
        $this->addressZipCode = preg_replace('/\D/', '', $addressZipCode);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressNeighborhood()
    {
        return $this->addressNeighborhood;
    }

    /**
     * @param mixed $addressNeighborhood
     * @return CheckoutEntity
     */
    public function setAddressNeighborhood($addressNeighborhood)
    {
        $this->addressNeighborhood = $addressNeighborhood;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddessStreet()
    {
        return $this->addessStreet;
    }

    /**
     * @param mixed $addessStreet
     * @return CheckoutEntity
     */
    public function setAddessStreet($addessStreet)
    {
        $this->addessStreet = $addessStreet;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressNumber()
    {
        return $this->addressNumber;
    }

    /**
     * @param mixed $addressNumber
     * @return CheckoutEntity
     */
    public function setAddressNumber($addressNumber)
    {
        $this->addressNumber = $addressNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressCity()
    {
        return $this->addressCity;
    }

    /**
     * @param mixed $addressCity
     * @return CheckoutEntity
     */
    public function setAddressCity($addressCity)
    {
        $this->addressCity = $addressCity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddressState()
    {
        return $this->addressState;
    }

    /**
     * @param mixed $addressState
     * @return CheckoutEntity
     */
    public function setAddressState($addressState)
    {
        $this->addressState = $addressState;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardName()
    {
        return $this->cardName;
    }

    /**
     * @param mixed $cardName
     * @return CheckoutEntity
     */
    public function setCardName($cardName)
    {
        $this->cardName = $cardName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @param mixed $cardNumber
     * @return CheckoutEntity
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = preg_replace('/\D/', '', $cardNumber);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardExpireDate()
    {
        return $this->cardExpireDate;
    }

    /**
     * @param mixed $cardExpireDate
     * @return CheckoutEntity
     */
    public function setCardExpireDate($cardExpireDate)
    {
        $this->cardExpireDate = preg_replace('/\D/', '', $cardExpireDate);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardCvv()
    {
        return $this->cardCvv;
    }

    /**
     * @param mixed $cardCvv
     * @return CheckoutEntity
     */
    public function setCardCvv($cardCvv)
    {
        $this->cardCvv = $cardCvv;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param $total
     * @return $this
     */
    public function setTotal($total)
    {
        $amountComplete = '';
        preg_match('/([0-9]*)\D([0-9]*)|([0-9]*)/', $total, $amountArray);
        if (!empty($amountArray[2]) && count($amountArray[2]) > 0) {
            if (count($amountArray[2]) == 1) {
                $amountComplete = '0';
            }
            $this->total += intval($amountArray[1] . $amountArray[2] . $amountComplete);
        } else {
            $this->total += intval($amountArray[0] . '00');
        }

        return $this;
    }
}