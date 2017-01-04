<?php

namespace PagarMe\Sdk\Recipient\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Balance\Operation;
use PagarMe\Sdk\Recipient\Recipient;

class RecipientBalanceOperation implements Request
{

    /**
     * @var Recipient
     */
    private $recipient;

    /**
     * @var int
     */
    private $operationId;

    /**
     * @var Recipient
     * @var int
     */
    public function __construct(Recipient $recipient, $operationId)
    {
        $this->recipient   = $recipient;
        $this->operationId = $operationId;
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
            'recipients/%s/balance/operations/%d',
            $this->recipient->getId(),
            $this->operationId
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
