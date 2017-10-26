<?php

namespace PagarMe\Acceptance;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use PagarMe\Sdk\SplitRule\SplitRuleCollection;
use PagarMe\Sdk\Account\Account;
use PagarMe\Sdk\Customer\Customer;
use PagarMe\Sdk\Customer\Address;
use PagarMe\Sdk\Customer\Phone;

class SubscriptionContext extends BasicContext
{
    private $customer;
    private $plan;
    private $creditCard;
    private $subscription;
    private $subscriptions;
    private $querySubscription;
    private $transactions;

    /**
     * @Given a valid customer
     */
    public function aValidCustomer()
    {
        $this->customer = self::getPagarMe()
            ->customer()
            ->create(
                'John Doe',
                'john@test.com',
                '25123317171',
                new Address(
                    [
                        'street'        => 'Rua Teste',
                        'street_number' => 123,
                        'neighborhood'  => 'Centro',
                        'zipcode'       => '01034020'
                    ]
                ),
                new Phone(
                    [
                        'ddd'    => '11',
                        'number' => '44445555'
                    ]
                )
            );
    }

    /**
     * @Given a valid plan
     */
    public function aValidPlan($planName = 'Test Plan')
    {
        $this->plan = self::getPagarMe()
            ->plan()
            ->create(555, 30, $planName);
    }

    /**
     * @Given a valid card
     */
    public function aValidCard($cardNumber = '4539706041746367')
    {
        $this->creditCard = self::getPagarMe()
            ->card()
            ->create($cardNumber, "John Doe", '0725');
    }

    /**
     * @When make a credit card subscription
     */
    public function makeACreditCardSubscription()
    {
        $this->subscription = self::getPagarMe()
            ->subscription()
            ->createCardSubscription(
                $this->plan,
                $this->creditCard,
                $this->customer
            );
    }


    /**
     * @When make a boleto subscription
     */
    public function makeABoletoSubscription()
    {
        $this->subscription = self::getPagarMe()
            ->subscription()
            ->createBoletoSubscription(
                $this->plan,
                $this->customer
            );
    }

    /**
     * @Then a subscription must be created
     */
    public function aSubscriptionMustBeCreated()
    {
        assertInstanceOf(
            'PagarMe\Sdk\Subscription\Subscription',
            $this->subscription
        );
    }

     /**
     * @Then the payment method must be :paymentMethod
     */
    public function thePaymentMethodMustBe($paymentMethod)
    {
        assertEquals($paymentMethod, $this->subscription->getPaymentMethod());
    }

    /**
     * @Given a previous created subscription
     */
    public function aPreviousCreatedSubscription()
    {
        $this->aValidCustomer();
        $this->aValidPlan();
        $this->makeABoletoSubscription();
    }

    /**
     * @Given a previous created credit card subscription
     */
    public function aPreviousCreatedCreditCardSubscription()
    {
        $this->aValidCustomer();
        $this->aValidPlan();
	$this->aValidCard();
        $this->makeACreditCardSubscription();
    }

    /**
     * @When I query for the subscription
     */
    public function iQueryForTheSubscription()
    {
        $this->querySubscription = self::getPagarMe()
            ->subscription()
            ->get($this->subscription->getId());
    }

    /**
     * @Then the same subscription must be returned
     */
    public function theSameSubscriptionMustBeReturned()
    {
        assertEquals(
            $this->subscription->getId(),
            $this->querySubscription->getId()
        );
    }

    /**
     * @Given previous created subscriptions
     */
    public function previousCreatedSubscriptions()
    {
        $this->aPreviousCreatedSubscription();
        $this->aPreviousCreatedSubscription();
        $this->aPreviousCreatedSubscription();
        sleep(2);
    }

    /**
     * @When I cancel the subscription
     */
    public function iCancelTheSubscription()
    {
        $this->subscription = self::getPagarMe()
            ->subscription()
            ->cancel($this->subscription);
    }

    /**
     * @Then subscription status must be :status
     */
    public function subscriptionStatusMustBe($status)
    {
        assertEquals($status, $this->subscription->getStatus());
    }

    /**
     * @When I update the subscription to use plan name :planName
     */
    public function iUpdateTheSubscriptionToUsePlan($planName)
    {
	$this->aValidPlan($planName);
	$this->subscription->setPlan($this->plan);
        $this->subscription = self::getPagarMe()
            ->subscription()
            ->update($this->subscription);
        $this->iQueryForTheSubscription();
    }

    /**
     * @When I update the subscription to use card number :cardNumber
     */
    public function iUpdateTheSubscriptionToUseCardNumber($cardNumber)
    {
        $this->aValidCard($cardNumber);
        $this->subscription->setCard($this->creditCard);
        $this->subscription = self::getPagarMe()
            ->subscription()
            ->update($this->subscription);
        $this->iQueryForTheSubscription();
    }

    /**
     * @Then must contain :needle in :key
     */
    public function mustContain($needle, $key)
    {
        $variableMethod = "get{$key}";
        $objectAttribute = call_user_func([$this->querySubscription, $variableMethod]);
        $serializeAttribute = json_encode((array) $objectAttribute);
        assertContains($needle, $serializeAttribute);
    }


    /**
     * @When I update the subscription to use payment method :paymentMethod
     */
    public function iUpdateTheSubscriptionPaymentMethod($paymentMethod)
    {
        $this->subscription->setPaymentMethod($paymentMethod);
        $this->subscription = self::getPagarMe()
            ->subscription()
            ->update($this->subscription);
        $this->iQueryForTheSubscription();
    }

    /**
     * @When I change the subscription all
     */
    public function iChangeTheSubscriptionAll()
    {
        $this->aValidPlan();
        $this->subscription->setPlan($this->plan);
        $this->subscription = self::getPagarMe()
            ->subscription()
            ->update($this->subscription);
        $this->iQueryForTheSubscription();
    }

}
