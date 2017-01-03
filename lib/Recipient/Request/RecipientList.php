<?php

namespace PagarMe\Sdk\Recipient\Request;

use PagarMe\Sdk\Request;

class RecipientList implements Request
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
            'page' => $this->page,
            'count' => $this->count
        ];
    }

    public function getPath()
    {
        return 'recipients';
    }

    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
