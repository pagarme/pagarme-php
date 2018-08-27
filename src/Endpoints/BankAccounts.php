<?php

namespace PagarMe\Endpoints;

use PagarMe\Client;
use PagarMe\Routes;
use PagarMe\Endpoints\Endpoint;

class BankAccounts extends Endpoint
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
            Routes::bankAccounts()->base(),
            ['json' => $payload]
        );
    }

    /*
     * @return \ArrayObject
     */
    public function getList()
    {
        return $this->client->request(
            self::GET,
            Routes::bankAccounts()->base()
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
            Routes::bankAccounts()->details($payload['id'])
        );
    }
}
