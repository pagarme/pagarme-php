<?php

namespace PagarMe\Sdk\Subscription\Request;

use PagarMe\Sdk\Request;

class SubscriptionList implements Request
{
    /**
     * @var int $page
     **/

    protected $page;
    /**
     * @var int $count
     **/
    protected $count;

    /**
     * @var int $page
     * @var int $count
    **/
    public function __construct($page, $count)
    {
        $this->page = $page;
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
        return 'subscriptions';
    }

    public function getMethod()
    {
        return 'GET';
    }
}
