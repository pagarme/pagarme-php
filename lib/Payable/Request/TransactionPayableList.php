<?php

namespace PagarMe\Sdk\Payable\Request;

use PagarMe\Sdk\RequestInterface;

class TransactionPayableList implements RequestInterface
{
    /**
     * @var int
     */
    private $transactionId;

    /**
     * @param int $transactionId
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
        return [
            'transaction_id'  => (string) $this->transactionId,
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'payables';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
