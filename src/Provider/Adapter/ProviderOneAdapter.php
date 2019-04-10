<?php

namespace App\Provider\Adapter;

use App\Provider\Model\ProviderOne;

class ProviderOneAdapter implements ProviderAdapter
{
    /**
     * @var ProviderOne
     */
    private $providerOne;

    /**
     * ProviderOneAdapter constructor.
     * @param $providerOne
     */
    public function __construct($providerOne)
    {
        $this->providerOne = $providerOne;
    }

    public function getCode()
    {
        switch ($this->providerOne->getKod()) {
            case "DOLAR":
                return "USD";
            case "AVRO":
                return "EUR";
            case "İNGİLİZ STERLİNİ":
                return "GBP";
        }

        return $this->providerOne->getKod();
    }

    public function getExchangeRate()
    {
        return $this->providerOne->getOran();
    }
}