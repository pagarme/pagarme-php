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
    public function getList()
    {
        return $this->client->request(
            EndpointInterface::GET,
            Routes::transactions()->base()
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function get(array $payload)
    {
        return $this->client->request(
            EndpointInterface::GET,
            Routes::transactions()->details($payload['id'])
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function capture(array $payload)
    {
        return $this->client->request(
            EndpointInterface::POST,
            Routes::transactions()->capture($payload['id']),
            ['json' => $payload]
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function refund(array $payload)
    {
        return $this->client->request(
            EndpointInterface::POST,
            Routes::transactions()->refund($payload['id']),
            ['json' => $payload]
        );
    }
}
