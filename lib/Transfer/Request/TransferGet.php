<?php

namespace PagarMe\Sdk\Transfer\Request;

use PagarMe\Sdk\Request;

class TransferGet implements Request
{
    /**
     * @var int
     **/
    private $transferId;

    /**
     * @param int $transferId
     **/
    public function __construct($transferId)
    {
        $this->transferId = $transferId;
    }

    public function getPayload()
    {
        return [];
    }

    public function getPath()
    {
        return sprintf('transfers/%d', $this->transferId);
    }

    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
