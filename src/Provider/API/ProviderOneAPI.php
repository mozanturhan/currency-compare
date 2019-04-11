<?php


namespace App\Provider\API;


use App\Provider\Adapter\ProviderAdapter;
use App\Provider\Adapter\ProviderOneAdapter;
use JMS\Serializer\SerializerInterface;

class ProviderOneAPI implements ProviderAPI
{
    public function getUrl()
    {
        return "http://www.mocky.io/v2/5a74524e2d0000430bfe0fa3";
    }

    public function getName()
    {
        return "Currency Provider One";
    }

    /**
     * @param SerializerInterface $serializer
     * @param $json
     * @return ProviderAdapter|array
     */
    public function parseJSON(SerializerInterface $serializer, $json)
    {
        $currencyList = $serializer->deserialize($json, 'array<App\Provider\Model\ProviderOne>', "json");
        $adapterList = [];
        foreach($currencyList as $curreny) {
            $adapterList[] = new ProviderOneAdapter($curreny);
        }

        return $adapterList;
    }


}