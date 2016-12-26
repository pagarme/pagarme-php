<?php

namespace PagarMe\Sdk\BalanceOperations\Request;

use PagarMe\Sdk\Request;

class BalanceOperationsGet implements Request
{

    private $balanceOperationId;

    public function __construct($balanceOperationId)
    {
        $this->balanceOperationId = $balanceOperationId;
    }

    public function getPayload()
    {
        return [];
    }

    public function getPath()
    {
        return sprintf('balance/operations/%d', $this->balanceOperationId);
    }

    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
