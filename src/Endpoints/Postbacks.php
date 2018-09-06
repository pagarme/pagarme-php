<?php

namespace PagarMe\Endpoints;

use PagarMe\Client;
use PagarMe\Routes;
use PagarMe\Endpoints\Endpoint;

class Postbacks extends Endpoint
{
    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function redeliver(array $payload)
    {
        return $this->client->request(
            self::POST,
            Routes::postbacks()->redeliver(
                $payload['model'],
                $payload['model_id'],
                $payload['postback_id']
            )
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
            Routes::postbacks()->details(
                $payload['model'],
                $payload['model_id'],
                $payload['postback_id']
            )
        );
    }

    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function getList(array $payload)
    {
        return $this->client->request(
            self::GET,
            Routes::postbacks()->base(
                $payload['model'],
                $payload['model_id']
            )
        );
    }
}
