<?php

namespace PagarMe\Sdk\Subscription\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Subscription\Subscription;

class SubscriptionUpdate implements Request
{
    /**
     * @var Subscription $subscription
     **/
    protected $subscription;

    /**
     * @var Subscription $subscription
    **/
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function getPayload()
    {
        $payload = [
            'plan'           => $this->subscription->getPlan()->getId(),
            'payment_method' => $this->subscription->getPaymentMethod()
        ];

        $card = $this->subscription->getCard();
        if ($card instanceof \PagarMe\Sdk\Card\Card) {
            $payload['card_id'] = $this->subscription->getCard()->getId();
        }

        return $payload;
    }

    public function getPath()
    {
        return sprintf('subscriptions/%d', $this->subscription->getId());
    }

    public function getMethod()
    {
        return 'PUT';
    }
}
