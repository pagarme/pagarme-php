<?php

namespace PagarMe\Endpoints;

use PagarMe\Client;

abstract class Endpoint
{
    /**
     * @var string
     */
    const POST = 'POST';
    /**
     * @var string
     */
    const GET = 'GET';
    /**
     * @var string
     */
    const PUT = 'PUT';
    /**
     * @var string
     */
    const DELETE = 'DELETE';

    /**
     * @var \PagarMe\Client
     */
    protected $client;

    /**
     * @param \PagarMe\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
