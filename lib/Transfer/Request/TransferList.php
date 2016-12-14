<?php

namespace PagarMe\Sdk\Transfer\Request;

use PagarMe\Sdk\Request;

class TransferList implements Request
{
    /**
     * @var int
     **/
    private $page;

    /**
     * @var int
     **/
    private $count;

    /**
     * @param int $page
     * @param int $count
     **/
    public function __construct($page, $count)
    {
        $this->page  = $page;
        $this->count = $count;
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
        return 'transfers';
    }

    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
