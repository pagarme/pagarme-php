<?php

namespace PagarMe\Endpoints;

use PagarMe\Client;
use PagarMe\Routes;
use PagarMe\Endpoints\EndpointInterface;

class Transactions
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

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function create(array $payload)
    {
        return $this->client->request(
            EndpointInterface::POST,
            Routes::transactions()->base(),
            ['json' => $payload]
        );
    }

    /*
     * @return \ArrayObject
     */
    public function get()
    {
        return $this->client->request(
            EndpointInterface::GET,
            Routes::transactions()->base()
        );
    }
}
