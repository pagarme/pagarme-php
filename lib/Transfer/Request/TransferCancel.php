<?php

namespace PagarMe\Sdk\Transfer\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Transfer\Transfer;

class TransferCancel implements Request
{
    /**
     * @var Transfer
     **/
    private $transfer;

    /**
     * @param $transfer
     **/
    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }

    public function getPayload()
    {
        return [];
    }

    public function getPath()
    {
        return sprintf('transfers/%d/cancel', $this->transfer->getId());
    }

    public function getMethod()
    {
        return self::HTTP_POST;
    }
}
