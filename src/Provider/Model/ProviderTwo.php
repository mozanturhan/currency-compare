<?php


namespace App\Provider\Model;


use JMS\Serializer\Annotation as Serializer;

class ProviderTwo
{
    /**
     * @Serializer\Type("string")
     */
    private $symbol;

    /**
     * @Serializer\Type("float")
     */
    private $amount;

    /**
     * @return mixed
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param mixed $symbol
     */
    public function setSymbol($symbol): void
    {
        $this->symbol = $symbol;
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
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }


}