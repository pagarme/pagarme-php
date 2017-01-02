<?php

namespace PagarMe\Sdk\BalanceOperations\Request;

use PagarMe\Sdk\Request;

class BalanceOperationsList implements Request
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
     * @var string
     */
    private $status;

    /**
     * @param int $page
     * @param int $count
     * @param int $status
     */
    public function __construct($page, $count, $status)
    {
        $this->page   = $page;
        $this->count  = $count;
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [
            'page'   => $this->page,
            'count'  => $this->count,
            'status' => $this->status
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'balance/operations';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
