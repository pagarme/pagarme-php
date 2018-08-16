<?php

namespace PagarMe\Endpoints;

use PagarMe\Client;

class Customers
{
    /**
     * @var \PagarMe\Client
     */
    private $client;

    /**
     * @param \Pagarme\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
