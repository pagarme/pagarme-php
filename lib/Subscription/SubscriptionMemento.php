<?php

namespace PagarMe\Sdk\Subscription;

use PagarMe\Sdk\Card\Card;
use PagarMe\Sdk\Plan\Plan;

class SubscriptionMemento
{
    /**
     * @var int $id
     */
    private $id;

    /**
     * @var Card $card
     */
    private $card;

    /**
     * @var Plan $plan
     */
    private $plan;

    /**
     * @var string $paymentMethod
     */
    private $paymentMethod;

    /**
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->setCard($subscription);
        $this->setPlan($subscription);
        $this->setPaymentMethod($subscription);
    }

    /**
     * @param Subscription $subscription
     * @codeCoverageIgnore
     */
    public function getId(Subscription $subscription)
    {
        $subscription->setId($this->id);
    }

    /**
     * @param Subscription $subscription
     * @codeCoverageIgnore
     */
    public function getCard(Subscription $subscription)
    { 
       if ($this->card instanceof \PagarMe\Sdk\Card\Card) {
           $subscription->setCard($this->card);
       }
    }

    /**
     * @param Subscription $subscription
     * @codeCoverageIgnore
     */
    public function setCard(Subscription $subscription)
    {
        $this->card = $subscription->getCard();
    }

    /**
     * @param Subscription $subscription
     * @codeCoverageIgnore
     */
    public function getPlan(Subscription $subscription)
    {
        $subscription->setPlan($this->plan);
    }

    /**
     * @param Subscription $subscription
     * @codeCoverageIgnore
     */
    public function setPlan(Subscription $subscription)
    {
        $this->plan = $subscription->getPlan();
    }

    /**
     * @param Subscription $subscription
     * @codeCoverageIgnore
     */
    public function getPaymentMethod(Subscription $subscription)
    {
        $subscription->setPaymentMethod($this->paymentMethod);
    }

    /**
     * @param Subscription $subscription
     * @codeCoverageIgnore
     */
    public function setPaymentMethod(Subscription $subscription)
    {
        $this->paymentMethod = $subscription->getPaymentMethod();
    }
}
