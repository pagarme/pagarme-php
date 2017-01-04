<?php

namespace PagarMe\Sdk\Recipient\Request;

use PagarMe\Sdk\Request;

class RecipientList implements Request
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
     * @return array
     */
    public function getPayload()
    {
        return [
            'page' => $this->page,
            'count' => $this->count
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'recipients';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'GET';
    }
}
