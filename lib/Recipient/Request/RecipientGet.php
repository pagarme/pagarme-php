<?php

namespace PagarMe\Sdk\Recipient\Request;

use PagarMe\Sdk\Request;

class RecipientGet implements Request
{

    private $recipientId;

    public function __construct($recipientId)
    {
        $this->recipientId  = $recipientId;
    }

    public function getPayload()
    {
        return [];
    }

    public function getPath()
    {
        return sprintf(
            'recipients/%s',
            $this->recipientId
        );
    }

    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
