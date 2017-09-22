<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\RequestInterface;

class TransactionFind implements RequestInterface
{
    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var array
     */
    private $filters;

    /**
     * @param array $filters
     * @param int   $page
     * @param int   $limit
     */
    public function __construct(array $filters, $page, $limit)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->filters = $filters;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return array_merge($this->filters, [
            'page' => $this->page,
            'count' => $this->limit,
        ]);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'transactions';
    }

    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
