<?php

namespace PagarMe\Endpoints;

use PagarMe\Routes;

class Company extends Endpoint
{
    /**
     * @return \ArrayObject
     */
    public function get()
    {
        return $this->client->request(
            self::GET,
            Routes::company()->base()
        );
    }
}
