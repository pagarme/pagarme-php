<?php

namespace PagarMe\Sdk\Subscription\Request;

use PagarMe\Sdk\Request;

class SubscriptionCancel implements Request
{
    /**
     * @var int $subscriptionId
     **/
    protected $subscriptionId;

    /**
     * @var int $subscriptionId
    **/
    public function __construct($subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }

    public function getPayload()
    {
        return [];
    }

    public function getPath()
    {
        return sprintf('subscriptions/%d/cancel', $this->subscriptionId);
    }

    public function getMethod()
    {
        return 'POST';
    }
}
