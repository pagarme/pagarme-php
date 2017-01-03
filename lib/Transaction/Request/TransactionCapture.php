<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Request;

class TransactionCapture implements Request
{
    protected $transactionId;
    protected $amount;

    /**
     * @codeCoverageIgnore
     */
    public function __construct($transactionId, $amount)
    {
        $this->transactionId = $transactionId;
        $this->amount = $amount;
    }

    public function getPayload()
    {
        if (is_null($this->amount)) {
            return [];
        }
        return [
            'amount' => $this->amount
        ];
    }

    public function getPath()
    {
        return sprintf('transactions/%d/capture', $this->transactionId);
    }

    public function getMethod()
    {
        return self::HTTP_POST;
    }
}
