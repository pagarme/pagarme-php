<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Transaction\BoletoTransaction;

class TransactionPay implements Request
{
    protected $transaction;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(BoletoTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function getPayload()
    {
        return [
            'status' => 'paid'
        ];
    }

    public function getPath()
    {
        return sprintf('transactions/%d', $this->transaction->getId());
    }

    public function getMethod()
    {
        return 'PUT';
    }
}
