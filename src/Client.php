<?php

namespace PagarMe;

class Client
{
    private $baseUrl = 'https://api.pagar.me:443/1';

    public function __construct($apiKey) {
        if (!validateAuthentication($apiKey)) {
            throw Exception('You must supply a valid Api Key');
        }

        $this->apiKey = $apiKey;
    }

    private function validateAuthentication($apiKey) {
        if (empty($apiKey) || is_null($apiKey)) {
            return false;
        }

        return true;
    }
}

