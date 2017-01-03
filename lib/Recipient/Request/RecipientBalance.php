<?php

namespace PagarMe\Sdk\Recipient\Request;

use PagarMe\Sdk\Request;

class RecipientBalance implements Request
{

    private $recipient;

    public function __construct($recipient)
    {
        $this->recipient  = $recipient;
    }

    public function getPayload()
    {
        return [];
    }

    public function getPath()
    {
        return sprintf(
            'recipients/%s/balance',
            $this->recipient->getId()
        );
    }

    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
