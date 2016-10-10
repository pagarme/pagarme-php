<?php

namespace PagarMe\Sdk;

use PagarMe\Sdk\Request;

interface Request
{
    const API_KEY        = 'api_key';
    const ENCRYPTION_KEY = 'encryption_key';

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

    /**
     * @return string
     */
    public function getAuthenticationMethod();
}
