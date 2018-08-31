<?php

namespace PagarMe\Endpoints;

use PagarMe\Client;
use PagarMe\Routes;
use PagarMe\Endpoints\Endpoint;

class Transfers extends Endpoint
{
    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function create(array $payload)
    {
        return $this->client->request(
            self::POST,
            Routes::transfers()->base(),
            ['json' => $payload]
        );
    }

    /**
     * @return \ArrayObject
     */
    public function getList()
    {
        return $this->client->request(
            self::GET,
            Routes::transfers()->base()
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
            self::GET,
            Routes::transfers()->details($payload['id'])
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function cancel(array $payload)
    {
        return $this->client->request(
            self::POST,
            Routes::transfers()->cancel($payload['id'])
        );
    }
}
