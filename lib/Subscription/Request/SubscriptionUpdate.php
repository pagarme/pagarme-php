<?php

namespace PagarMe\Sdk\Subscription\Request;

use PagarMe\Sdk\RequestInterface;
use PagarMe\Sdk\Subscription\Subscription;

class SubscriptionUpdate implements RequestInterface
{
    const CREDIT_CARD = 'credit_card';
    const BOLETO = 'boleto';

    /**
     * @var Subscription $subscription
     */
    protected $subscription;

    /**
     * @var Subscription $subscriptionMemento
     */
    protected $subscriptionMemento;

    /**
     * @param Subscription $subscription
     * @param Subscription $subscriptionMemento
     */
    public function __construct(Subscription $subscription, Subscription $subscriptionMemento)
    {
        $this->subscription = $subscription;
        $this->subscriptionMemento = $subscriptionMemento;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        $payload = new \ArrayObject();
        $this->loadCard($payload);
        $this->loadPlanId($payload);
        $this->loadPaymentMethod($payload);
        
        return $payload->getArrayCopy();
    }

    /**
     * @param ArrayObject $payload
     * @return ArrayObject $payload
     */
    protected function loadCard(\ArrayObject $payload)
    {
        $newCard = $this->subscription->getCard();
        $mementoCard = $this->subscriptionMemento->getCard();
        
        if (!$newCard instanceof \PagarMe\Sdk\Card\Card || !$mementoCard instanceof \PagarMe\Sdk\Card\Card) {
            return $payload;
        }

        if ($this->isCardIdChanged() || $this->isPreviousPaymentMethodBoleto()) {
            $payload->offsetSet('card_id', $newCard->getId());
            $payload->offsetSet('payment_method', self::CREDIT_CARD);
        }
    }

    /**
     * @return bool 
     */
    protected function isCardIdChanged()
    {
        return $this->subscription->getCard()->getId() != $this->subscriptionMemento->getCard()->getId();
    }

    /**
     * @return bool
     */
    protected function isPreviousPaymentMethodBoleto()
    {
       return $this->subscriptionMemento->getPaymentMethod() == self::BOLETO;
    }

    /**
     * @param ArrayObject $payload
     * @return ArrayObject $payload
     */
    protected function loadPlanId(\ArrayObject $payload)
    {
        $newPlan = $this->subscription->getPlan();
        $mementoPlan = $this->subscriptionMemento->getPlan();

        if (!$newPlan instanceof \PagarMe\Sdk\Plan\Plan || !$mementoPlan instanceof \PagarMe\Sdk\Plan\Plan) {
            return $payload;
        }

        if ($newPlan->getId() != $mementoPlan->getId()) {
           $payload->offsetSet('plan_id', $newPlan->getId());
        }
    }

    /**
     * @param ArrayObject $payload
     * @return ArrayObject $payload
     */
    protected function loadPaymentMethod(\ArrayObject $payload)
    { 
        $newPaymentMethod = $this->subscription->getPaymentMethod();
        $mementoPaymentMethod = $this->subscriptionMemento->getPaymentMethod();

        if ($newPaymentMethod != $mementoPaymentMethod) {
            $payload->offsetSet('payment_method', $newPaymentMethod);
        }
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
