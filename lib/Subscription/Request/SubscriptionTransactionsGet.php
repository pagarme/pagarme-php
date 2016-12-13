<?php

namespace PagarMe\Sdk\Subscription\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Subscription\Subscription;

class SubscriptionTransactionsGet implements Request
{
    /**
     * @var Subscription $subscription
     **/
    protected $subscription;

    /**
     * @param Subscription $subscription
    **/
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function getPayload()
    {
        return [];
    }

    public function getPath()
    {
        return sprintf(
            'subscriptions/%d/transactions',
            $this->subscription->getId()
        );
    }

    public function getMethod()
    {
        return 'GET';
    }
}
