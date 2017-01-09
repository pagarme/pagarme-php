<?php

namespace PagarMe\Sdk\AntifraudAnalyses\Request;

use PagarMe\Sdk\RequestInterface;

class AntifraudAnalysesList implements RequestInterface
{
    /**
     * @var PagarMe\Sdk\Transaction\AbstractTransaction
     */
    private $transaction;

    /**
     * @param PagarMe\Sdk\Transaction\AbstractTransaction $transaction
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
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
            'transactions/%d/antifraud_analyses',
            $this->transaction->getId()
        );
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
