<?php

namespace PagarMe\Sdk\BalanceOperations\Request;

use PagarMe\Sdk\Request;

class BalanceOperationsGet implements Request
{
    /**
     * @var int
     */
    private $balanceOperationId;

    /**
     * @param int $balanceOperationId
     */
    public function __construct($balanceOperationId)
    {
        $this->balanceOperationId = $balanceOperationId;
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
        return sprintf('balance/operations/%d', $this->balanceOperationId);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
