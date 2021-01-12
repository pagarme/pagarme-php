<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\RequestInterface;
use PagarMe\Sdk\Transaction\PixTransaction;

class PixTransactionRefund implements RequestInterface
{
    /**
     * @var PixTransaction
     */
    protected $transaction;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @param PixTransaction $transaction
     * @param int $amount
     */
    public function __construct(PixTransaction $transaction, $amount)
    {
        $this->transaction = $transaction;
        $this->amount      = $amount;
    }

    /**
     * @param string
     */
    public function getPayload()
    {
        return [
            'amount' => $this->amount
        ];
    }

    /**
     * @param string
     */
    public function getPath()
    {
        return sprintf('transactions/%d/refund', $this->transaction->getId());
    }

    /**
     * @param string
     */
    public function getMethod()
    {
        return self::HTTP_POST;
    }
}
