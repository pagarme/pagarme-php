<?php

namespace PagarMe\Sdk\Card\Request;

use PagarMe\Sdk\Request;

class PublicKey implements Request
{
    /**
     * @return array
     */
    public function getPayload()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'transactions/card_hash_key';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'GET';
    }

    /**
     * @return string
     */
    public function getAuthenticationMethod()
    {
        return self::ENCRYPTION_KEY;
    }
}
