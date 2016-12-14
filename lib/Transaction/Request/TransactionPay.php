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

    /**
     * @return array
     */
    public function getPayload()
    {
        return [
            'status' => 'paid'
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return sprintf('transactions/%d', $this->transaction->getId());
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_PUT;
    }
}
