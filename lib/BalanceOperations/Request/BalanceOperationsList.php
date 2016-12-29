<?php

namespace PagarMe\Sdk\BalanceOperations\Request;

use PagarMe\Sdk\Request;

class BalanceOperationsList implements Request
{

    private $page;
    private $count;
    private $status;

    public function __construct($page, $count, $status)
    {
        $this->page    = $page;
        $this->count   = $count;
        $this->status = $status;
    }

    public function getPayload()
    {
        return [
            'page'   => $this->page,
            'count'  => $this->count,
            'status' => $this->status
        ];
    }

    public function getPath()
    {
        return 'balance/operations';
    }

    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
