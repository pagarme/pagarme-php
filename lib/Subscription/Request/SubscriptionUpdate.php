<?php

namespace PagarMe\Sdk\Subscription\Request;

use PagarMe\Sdk\RequestInterface;
use PagarMe\Sdk\Subscription\Subscription;

class SubscriptionUpdate implements RequestInterface
{
    /**
     * @var Subscription $subscription
     */
    protected $subscription;

    /**
     * @var Subscription $subscriptionCookie
     */
    protected $subscriptionCookie;

    /**
     * @param Subscription $subscription
     * @param Subscription $subscriptionCookie
     */
    public function __construct(Subscription $subscription, Subscription $subscriptionCookie)
    {
        $this->subscription = $subscription;
        $this->subscriptionCookie = $subscriptionCookie;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        $payload = new \ArrayObject();
        $this->getLoadCard($payload);
        $this->getLoadPlanId($payload);
        $this->getLoadPaymentMethod($payload);

        return $payload->getArrayCopy();
    }

    /**
     * @param ArrayObject $payload
     * @return ArrayObject $payload
     */
    protected function getLoadCard(\ArrayObject $payload)
    {
        $card = $this->subscription->getCard();

        if ($card instanceof \PagarMe\Sdk\Card\Card) {
            $payload->offsetSet('card_id', $card->getId());
        }

        return $payload;
    }

    /**
     * @param ArrayObject $payload
     * @return ArrayObject $payload
     */
    protected function getLoadPlanId(\ArrayObject $payload)
    {
        $newPlan = $this->subscription->getPlan();
        $cookiePlan = $this->subscriptionCookie->getPlan();

        if (!$newPlan instanceof \PagarMe\Sdk\Plan\Plan || !$cookiePlan instanceof \PagarMe\Sdk\Plan\Plan) {
            return $payload;
        }

        if ($newPlan->getId() != $cookiePlan->getId()) {
           $payload->offsetSet('plan_id', $newPlan->getId());
        }

        return $payload;
    }

    /**
     * @param ArrayObject $payload
     * @return ArrayObject $payload
     */
    protected function getLoadPaymentMethod(\ArrayObject $payload)
    { 
        $newPaymentMethod = $this->subscription->getPaymentMethod();
        $cookiePaymentMethod = $this->subscriptionCookie->getPaymentMethod();

        if ($newPaymentMethod != $cookiePaymentMethod) {
            $payload->offsetSet('payment_method', $newPaymentMethod);
        }

        return $payload;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return sprintf('subscriptions/%d', $this->subscription->getId());
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_PUT;
    }
}
