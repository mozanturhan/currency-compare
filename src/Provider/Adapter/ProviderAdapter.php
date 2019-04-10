<?php


namespace App\Provider\Adapter;


interface ProviderAdapter
{
    public function getCode();
    public function getExchangeRate();
}