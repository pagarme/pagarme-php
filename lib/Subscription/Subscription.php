<?php

namespace PagarMe\Sdk\Subscription;

use PagarMe\Sdk\Transaction\Transaction;
use PagarMe\Sdk\Card\Card;
use PagarMe\Sdk\Plan\Plan;

class Subscription
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var int $id
     **/
    private $id;

    /**
     * @var Card $card
     **/
    private $card;

    /**
     * @var Plan $plan
     **/
    private $plan;

    /**
     * @var Customer $customer
     **/
    private $customer;

    /**
     * @var string $postbackUrl
     **/
    private $postbackUrl;

    /**
     * @var array $metadata
     **/
    private $metadata;

    /**
     * @var Transaction $currentTransaction
     **/
    private $currentTransaction;

    /**
     * @var string $paymentMethod
     **/
    private $paymentMethod;

    /**
     * @var string $currentPeriodStart
     **/
    private $currentPeriodStart;

    /**
     * @var string $currentPeriodEnd
     **/
    private $currentPeriodEnd;

    /**
     * @var int $charges
     **/
    private $charges;

    /**
     * @var string $status
     **/
    private $status;

    /**
     * @var string $dateCreated
     **/
    private $dateCreated;


    /**
     * @param array $subscriptionData
    **/
    public function __construct($subscriptionData)
    {
        $this->fill($subscriptionData);
    }

    /**
     * @return int
     **/
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Card
     **/
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param Card
     **/
    public function setCard(Card $card)
    {
        $this->card = $card;
        return $this;
    }

    /**
     * @return Plan
     **/
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @param Plan
     **/
    public function setPlan(Plan $plan)
    {
        $this->plan = $plan;
        return $this;
    }

    /**
     * @return Customer
     **/
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return string
     **/
    public function getPostbackUrl()
    {
        return $this->postbackUrl;
    }

    /**
     * @return array
     **/
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return Transaction
     **/
    public function getCurrentTransaction()
    {
        return $this->currentTransaction;
    }

    /**
     * @return string
     **/
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param string
     **/
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    /**
     * @return string
     **/
    public function getCurrentPeriodStart()
    {
        return $this->currentPeriodStart;
    }

    /**
     * @return string
     **/
    public function getCurrentPeriodEnd()
    {
        return $this->currentPeriodEnd;
    }

    /**
     * @return int
     **/
    public function getCharges()
    {
        return $this->charges;
    }

    /**
     * @return string
     **/
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     **/
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
}
