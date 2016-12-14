<?php

namespace PagarMe\Sdk;

use PagarMe\Sdk\Request;

interface Request
{
    const HTTP_GET  = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_PUT  = 'PUT';

    /**
     * @return array
     */
    public function getPayload();

    /**
     * @return string
     */
    public function getPath();

    /**
     * @return string
     */
    public function getMethod();
}
