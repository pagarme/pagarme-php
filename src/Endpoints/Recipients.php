<?php

namespace PagarMe\Endpoints;

use PagarMe\Client;
use PagarMe\Routes;
use PagarMe\Endpoints\Endpoint;

class Recipients extends Endpoint
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
            Routes::recipients()->base(),
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
            Routes::recipients()->base()
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
            Routes::recipients()->details($payload['id'])
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function update(array $payload)
    {
        return $this->client->request(
            self::PUT,
            Routes::recipients()->details($payload['id'])
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function getBalance(array $payload)
    {
        return $this->client->request(
            self::GET,
            Routes::recipients()->balance($payload['id'])
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function getBalanceOperationList(array $payload)
    {
        return $this->client->request(
            self::GET,
            Routes::recipients()->balanceOperations($payload['id'])
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function getBalanceOperation(array $payload)
    {
        return $this->client->request(
            self::GET,
            Routes::recipients()->balanceOperation(
                $payload['recipient_id'],
                $payload['balance_operation_id']
            )
        );
    }
}
