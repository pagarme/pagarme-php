<?php

namespace PagarMe\Endpoints;

use PagarMe\Client;

abstract class Endpoint
{
    /**
     * @var \PagarMe\Client
     */
    protected $client;

    /**
     * @param \Pagarme\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
