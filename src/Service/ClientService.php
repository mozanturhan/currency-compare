<?php


namespace App\Service;



use GuzzleHttp\Client;

class ClientService
{
    public function call($url) {
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->get($url);

        return $response->getBody()->getContents();
    }
}