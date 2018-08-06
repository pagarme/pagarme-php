<?php

namespace PagarMe\Endpoints;

use PagarMe\Client;

class Transactions
{
    /**
     * @var \PagarMe\Client
     */
    private $client;

    /**
     * @param $client \Pagarme\Client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
