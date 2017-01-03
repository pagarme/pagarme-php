<?php

namespace PagarMe\Sdk\Recipient\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Balance\Operation;
use PagarMe\Sdk\Recipient\Recipient;

class RecipientBalanceOperation implements Request
{

    private $recipient;
    private $operationId;

    public function __construct(Recipient $recipient, $operationId)
    {
        $this->recipient   = $recipient;
        $this->operationId = $operationId;
    }

    public function getPayload()
    {
        return [];
    }

    public function getPath()
    {
        return sprintf(
            'recipients/%s/balance/operations/%d',
            $this->recipient->getId(),
            $this->operationId
        );
    }

    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
