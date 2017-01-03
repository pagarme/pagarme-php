<?php

namespace PagarMe\Sdk\Recipient\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Recipient\Recipient;

class RecipientBalanceOperations implements Request
{

    private $recipient;
    private $page;
    private $count;

    public function __construct(Recipient $recipient, $page, $count)
    {
        $this->recipient = $recipient;
        $this->page      = $page;
        $this->count     = $count;
    }

    public function getPayload()
    {
        return [
            'page'  => $this->page,
            'count' => $this->count
        ];
    }

    public function getPath()
    {
        return sprintf(
            'recipients/%s/balance/operations',
            $this->recipient->getId()
        );
    }

    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
