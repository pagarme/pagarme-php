<?php

namespace PagarMe\Sdk\Recipient\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Recipient\Recipient;

class RecipientBalance implements Request
{
    /**
     * @var Recipient
     */
    private $recipient;

    /**
     * @param Recipient $recipient
     */
    public function __construct($recipient)
    {
        $this->recipient  = $recipient;
    }

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
        return sprintf(
            'recipients/%s/balance',
            $this->recipient->getId()
        );
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'GET';
    }
}
