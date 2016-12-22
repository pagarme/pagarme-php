<?php

namespace PagarMe\Sdk\BalanceOperations\Request;

use PagarMe\Sdk\Request;

class BalanceOperationsList implements Request
{

    private $page;
    private $count;

    public function __construct($page, $count)
    {
        $this->page      = $page;
        $this->count     = $count;
    }

    public function getPayload()
    {
        return [
            'page'  => $this->page,
            'count' => $this->count
        ];
    }

    public function getPath()
    {
        return 'balance/operations';
    }

    public function getMethod()
    {
        return 'GET';
    }
}
