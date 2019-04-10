<?php

namespace App\Provider\API;

use App\Provider\Adapter\ProviderTwoAdapter;
use App\Provider\Model\ProviderTwoResult;
use JMS\Serializer\SerializerInterface;

class ProviderTwoAPI implements ProviderAPI
{
    public function getUrl()
    {
       return "http://www.mocky.io/v2/5a74519d2d0000430bfe0fa0";
    }

    public function getName()
    {
        return "Currency Provider One";
    }

    public function parseJSON(SerializerInterface $serializer, $json)
    {
        $providerTwoResult = $serializer->deserialize($json, ProviderTwoResult::class, "json");
        $adapterList = [];
        foreach($providerTwoResult->getResult() as $curreny) {
            $adapterList[] = new ProviderTwoAdapter($curreny);
        }

        return $adapterList;
    }
}