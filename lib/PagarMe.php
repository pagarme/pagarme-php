<?php

namespace PagarMe\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use PagarMe\Sdk\Customer\CustomerHandler;
use PagarMe\Sdk\Transaction\TransactionHandler;
use PagarMe\Sdk\Card\CardHandler;
use PagarMe\Sdk\Calculation\CalculationHandler;
use PagarMe\Sdk\Recipient\RecipientHandler;
use PagarMe\Sdk\Plan\PlanHandler;
use PagarMe\Sdk\SplitRule\SplitRuleHandler;
use PagarMe\Sdk\BankAccount\BankAccountHandler;
use PagarMe\Sdk\Subscription\SubscriptionHandler;

class PagarMe
{
    /**
     * @param Client
     */
    private $client;

    /**
     * @param CustomerHandler
     */
    private $customerHandler;

    /**
     * @param TransactionHandler
     */
    private $transactionHandler;

    /**
     * @param CardHandler
     */
    private $cardHandler;

    /**
     * @param CalculationHandler
     */
    private $calculationHandler;

    /**
     * @param RecipientHandler
     */
    private $recipientHandler;

    /**
     * @param PlanHandler
     */
    private $planHandler;

    /**
     * @param SplitRuleHandler
     */
    private $splitRuleHandler;

    /**
     * @param BankAccount
     */
    private $bankAccountHandler;

    /**
     * @param SubscriptionHandler
     */
    private $subscriptionHandler;

    /**
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->client = new Client(
            new GuzzleClient(
                [
                    'base_url' => 'https://api.pagar.me/1/'
                ]
            ),
            $apiKey
        );
    }

    /**
     * @return CustomerHandler
     */
    public function customer()
    {
        if (!$this->customerHandler instanceof CustomerHandler) {
            $this->customerHandler = new CustomerHandler($this->client);
        }

        return $this->customerHandler;
    }

    /**
     * @return TransactionHandler
     */
    public function transaction()
    {
        if (!$this->transactionHandler instanceof TransactionHandler) {
            $this->transactionHandler = new TransactionHandler($this->client);
        }

        return $this->transactionHandler;
    }

    /**
     * @return CardHandler
     */
    public function card()
    {
        if (!$this->cardHandler instanceof CardHandler) {
            $this->cardHandler = new CardHandler($this->client);
        }

        return $this->cardHandler;
    }

    /**
     * @return CalculationHandler
     */
    public function calculation()
    {
        if (!$this->calculationHandler instanceof CalculationHandler) {
            $this->calculationHandler = new CalculationHandler($this->client);
        }

        return $this->calculationHandler;
    }

    /**
     * @return RecipientHandler
     */
    public function recipient()
    {
        if (!$this->recipientHandler instanceof RecipientHandler) {
            $this->recipientHandler = new RecipientHandler($this->client);
        }

        return $this->recipientHandler;
    }

    /**
     * @return PlanHandler
     */
    public function plan()
    {
        if (!$this->planHandler instanceof PlanHandler) {
            $this->planHandler = new PlanHandler($this->client);
        }

        return $this->planHandler;
    }

    /**
     * @return SplitRuleHandler
     */
    public function splitRule()
    {
        if (!$this->splitRuleHandler instanceof SplitRuleHandler) {
            $this->splitRuleHandler = new SplitRuleHandler();
        }

        return $this->splitRuleHandler;
    }

    /**
     * @return BankAccountHandler
     */
    public function bankAccount()
    {
        if (!$this->bankAccountHandler instanceof BankAccountHandler) {
            $this->bankAccountHandler = new BankAccountHandler($this->client);
        }

        return $this->bankAccountHandler;
    }

    /**
     * @return SubscriptionHandler
     */
    public function subscription()
    {
        if (!$this->subscriptionHandler instanceof SubscriptionHandler) {
            $this->subscriptionHandler = new SubscriptionHandler($this->client);
        }

        return $this->subscriptionHandler;
    }
}
