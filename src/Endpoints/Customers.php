<?php

namespace PagarMe\Endpoints;

use PagarMe\Client;
use PagarMe\Routes;
use PagarMe\Endpoints\Endpoint;

class Customers extends Endpoint
{
    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function create(array $payload)
    {
        return $this->client->request(
            EndpointInterface::POST,
            Routes::customers()->base(),
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
            Routes::customers()->base()
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
            Routes::customers()->details($payload['id'])
        );
    }
}
