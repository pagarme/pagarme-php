<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Request;

class TransactionGet implements Request
{
    /**
     * @var int
     */
    protected $transactionId;

    /**
     * @param int transactionId
     */
    public function __construct($transactionId)
    {
        $this->transactionId = $transactionId;
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
        return sprintf('transactions/%d', $this->transactionId);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
