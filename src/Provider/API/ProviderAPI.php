<?php

namespace App\Provider\API;

use App\Provider\Adapter\ProviderAdapter;
use App\Service\ClientService;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;

interface ProviderAPI
{
    public function getUrl();
    public function getName();

    /**
     * @param SerializerInterface $serializer
     * @param $json
     * @return ProviderAdapter[] | array
     *
     */
    public function parseJSON(SerializerInterface $serializer, $json);
}