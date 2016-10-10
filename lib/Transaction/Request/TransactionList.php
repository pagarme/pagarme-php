<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Request;

class TransactionList implements Request
{
    private $page;
    private $count;

    public function __construct($page, $count)
    {
        $this->page  = $page;
        $this->count = $count;
    }

    public function getPayload()
    {
        return [
            'page'  => $this->page,
            'count' => $this->count,
        ];
    }

    public function getPath()
    {
        return 'transactions';
    }

    public function getMethod()
    {
        return 'GET';
    }

    /**
     * @return string
     */
    public function getAuthenticationMethod()
    {
        return self::API_KEY;
    }
}
