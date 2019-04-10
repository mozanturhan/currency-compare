<?php

namespace App\Provider\Adapter;

use App\Provider\Model\ProviderTwo;

class ProviderTwoAdapter implements ProviderAdapter
{
    /**
     * @var ProviderTwo
     */
    private $providerTwo;

    /**
     * ProviderTwoAdapter constructor.
     * @param $providerTwo
     */
    public function __construct($providerTwo)
    {
        $this->providerTwo = $providerTwo;
    }

    public function getCode()
    {
        switch ($this->providerTwo->getSymbol()) {
            case "USDTRY":
                return "USD";
            case "EURTRY":
                return "EUR";
            case "GBPTRY":
                return "GBP";
        }

        return $this->providerTwo->getSymbol();
    }

    public function getExchangeRate()
    {
        return $this->providerTwo->getAmount();
    }
}