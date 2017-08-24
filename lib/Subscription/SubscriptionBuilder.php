<?php

namespace PagarMe\Sdk\Subscription;

use PagarMe\Sdk\Card\Card;
use PagarMe\Sdk\Customer\Customer;
use PagarMe\Sdk\Plan\Plan;

trait SubscriptionBuilder
{
    use \PagarMe\Sdk\Transaction\TransactionBuilder;

    /**
     * @var SubscriptonMemento $subscriptionMemento
     */
    public $subscriptionMemento;
	
    /**
     * @param array $subscriptionData
     * @return Subscription
     */
    private function buildSubscription($subscriptionData)
    {
        if (is_object($subscriptionData->card)) {
            $subscriptionData->card = new Card(
                get_object_vars($subscriptionData->card)
            );
        }

        $subscriptionData->current_period_start = new \DateTime(
            $subscriptionData->current_period_start
        );
        $subscriptionData->current_period_end = new \DateTime(
            $subscriptionData->current_period_end
        );

        $subscriptionData->plan = new Plan(
            get_object_vars($subscriptionData->plan)
        );
        $subscriptionData->customer = new Customer(
            get_object_vars($subscriptionData->customer)
        );

        if (is_object($subscriptionData->current_transaction)) {
            $subscriptionData->current_transaction = $this->buildTransaction(
                $subscriptionData->current_transaction
            );
        }

        $subscription = new Subscription(get_object_vars($subscriptionData));
        $this->subscriptionMemento = new SubscriptionMemento($subscription);

        return $subscription;
    }
   
    public function getSubscriptionMemento()
    {
        return $this->subscriptionMemento;
    }
}
