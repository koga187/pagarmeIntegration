<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 8/5/17
 * Time: 6:55 PM
 */

namespace TestPagarme\Entity;


class ProductEntity
{
    private $id;

    private $value;

    private $quantity;

    /**
     * @var float $total
     */
    private $total;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ProductEntity
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return ProductEntity
     */
    public function setValue($value)
    {
        $this->value = floatval($value);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     * @return ProductEntity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return $this
     */
    public function setTotal()
    {

        $this->total = floatval($this->value * $this->quantity);

        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function __toArray()
    {
        self::setTotal();

        return [
            'id' => $this->id,
            'value' => $this->value,
            'quantity' => $this->quantity,
            'totalProduct' => $this->total
        ];
    }
}