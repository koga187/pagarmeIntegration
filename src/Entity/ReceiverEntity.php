<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 8/6/17
 * Time: 12:31 PM
 */

namespace TestPagarme\Entity;


class ReceiverEntity
{
    private $id;

    private $chargeProcessingFee = true;

    private $percentage;

    private $amount;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ReceiverEntity
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChargeProcessingFee()
    {
        return $this->chargeProcessingFee;
    }

    /**
     * @param mixed $chargeProcessingFee
     * @return ReceiverEntity
     */
    public function setChargeProcessingFee($chargeProcessingFee)
    {
        $this->chargeProcessingFee = $chargeProcessingFee;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param mixed $percentage
     * @return ReceiverEntity
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     * @return ReceiverEntity
     */
    public function setAmount($amount)
    {
        $this->amount = intval(preg_replace('/\D/', '', $amount . '00'));;
        return $this;
    }

    /**
     * @param mixed $amount
     * @return ReceiverEntity
     */
    public function addAmount(float $amount)
    {
        $amountComplete = '';
        preg_match('/([0-9]*)\D([0-9]*)|([0-9]*)/', $amount, $amountArray);
        if (!empty($amountArray[2]) && count($amountArray[2]) > 0) {
            if (count($amountArray[2]) == 1) {
                $amountComplete = '0';
            }
            $this->amount += intval($amountArray[1] . $amountArray[2] . $amountComplete);
        } else {
            $this->amount += intval($amountArray[0] . '00');
        }

        return $this;
    }
}