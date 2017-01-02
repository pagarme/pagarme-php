<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Request;

class TransactionList implements Request
{
    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $count;

    /**
     * @param int $page
     * @param int $count
     */
    public function __construct($page, $count)
    {
        $this->page  = $page;
        $this->count = $count;
    }

    /**
     * @return array array
     */
    public function getPayload()
    {
        return [
            'page'  => $this->page,
            'count' => $this->count,
        ];
    }

    /**
     * @return array string
     */
    public function getPath()
    {
        return 'transactions';
    }

    /**
     * @return array string
     */
    public function getMethod()
    {
        return 'GET';
    }
}
