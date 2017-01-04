<?php

namespace PagarMe\Sdk\Subscription\Request;

use PagarMe\Sdk\Request;

class SubscriptionCancel implements Request
{
    /**
     * @var int $subscriptionId
     */
    protected $subscriptionId;

    /**
     * @var int $subscriptionId
     */
    public function __construct($subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return sprintf('subscriptions/%d/cancel', $this->subscriptionId);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'POST';
    }
}
