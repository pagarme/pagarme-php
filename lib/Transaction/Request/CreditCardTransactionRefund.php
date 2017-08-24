<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\RequestInterface;
use PagarMe\Sdk\Transaction\CreditCardTransaction;

class CreditCardTransactionRefund implements RequestInterface
{
    /**
     * @var CreditCardTransaction
     */
    protected $transaction;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @var bool
     */
    protected $async;

    /**
     * @param CreditCardTransaction $transaction
     * @param int $amount
     * @param bool $async
     */
    public function __construct(CreditCardTransaction $transaction, $amount, $async = true)
    {
        $this->transaction = $transaction;
        $this->amount      = $amount;
        $this->async       = $async;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return [
            'amount' => $this->amount,
            'async' => $this->async,
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return sprintf('transactions/%d/refund', $this->transaction->getId());
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_POST;
    }
}
