<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\RequestInterface;

class TransactionList implements RequestInterface
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
     * @var array
     */
    private $extraParameters;

    /**
     * @param $page
     * @param $count
     * @param array $extraParameters
     */
    public function __construct($page, $count, array $extraParameters = [])
    {
        $this->page  = $page;
        $this->count = $count;
        $this->extraParameters = $extraParameters;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return array_merge([
            'page'  => $this->page,
            'count' => $this->count,
        ], $this->extraParameters);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'transactions';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
