<?php

namespace PagarMe;

class Client
{
    private $baseUrl = 'https://api.pagar.me:443/1';

    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }
}

