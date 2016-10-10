<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Request;

class TransactionGet implements Request
{
    protected $transactionId;

    /**
     * @codeCoverageIgnore
     */
    public function __construct($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function getPayload()
    {
        return [];
    }

    public function getPath()
    {
        return sprintf('transactions/%d', $this->transactionId);
    }

    public function getMethod()
    {
        return 'GET';
    }

    /**
     * @return string
     */
    public function getAuthenticationMethod()
    {
        return self::API_KEY;
    }
}
