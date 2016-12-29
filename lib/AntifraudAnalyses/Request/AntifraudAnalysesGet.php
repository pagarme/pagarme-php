<?php

namespace PagarMe\Sdk\AntifraudAnalyses\Request;

use PagarMe\Sdk\Request;

class AntifraudAnalysesGet implements Request
{
    /**
     * @var PagarMe\Sdk\Transaction\AbstractTransaction
     */
    private $transaction;

    /**
     * @var int
     */
    private $antifraudAnalyses;

    /**
     * @param PagarMe\Sdk\Transaction\AbstractTransaction $transaction
     */
    public function __construct($transaction, $antifraudAnalyses)
    {
        $this->transaction       = $transaction;
        $this->antifraudAnalyses = $antifraudAnalyses;
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
            'transactions/%d/antifraud_analyses/%d',
            $this->transaction->getId(),
            $this->antifraudAnalyses
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
