<?php

namespace PagarMe\Endpoints\Transactions;

use PagarMe\Client;

class Transactions implements EndpointInterface
{
    public $uri = 'transactions';

    public $method = '';

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
