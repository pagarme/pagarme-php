<?php

namespace PagarMe\Acceptance;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use PagarMe\Sdk\Customer\Customer;

class BulkAnticipationContext extends BasicContext
{
    use Helper\CustomerDataProvider;

    private $recipient;
    private $anticipation;
    private $expectedPaymentDate;
    private $expectedTimeframe;
    private $expectedRequestedAmount;

    /**
     * @Given a recipient with anticipatable volume
     */
    public function aRecipientWithAnticipatableVolume()
    {
        $companyInformation = self::getPagarMe()->company()->info();

        $recipient = self::getPagarMe()->recipient()->get(
            $companyInformation->default_recipient_id->test
        );

        $recipient->setAnticipatableVolumePercentage(100);

        $this->recipient = self::getPagarMe()->recipient()->update($recipient);
    }

    /**
     * @Given company has paid transaction with :amount
     */
    public function whichCompanyHasTransactionPaidWith($amount)
    {
        $creditCard = self::getPagarMe()
            ->card()
            ->create('4556425889100276', 'João Silva', '0623');

        $customerData = $this->getValidCustomerData();
        $customer = new Customer($customerData);

        $transaction = self::getPagarMe()
            ->transaction()
            ->creditCardTransaction(
                $amount,
                $creditCard,
                $customer,
                1
            );
    }

    /**
     * @When register a anticipation with :paymentDate, :timeframe, :requestedAmount
     */
    public function registerAAnticipationWith($paymentDate, $timeframe, $requestedAmount)
    {
        $paymentDate = new \Datetime($paymentDate, new \DateTimeZone('UTC'));

        $weekday = $paymentDate->format('w');

        if (in_array($weekday, [0,6])) {
            $paymentDate = new \Datetime('+3 days', new \DateTimeZone('UTC'));
        }

        $paymentDate->setTime(3, 0, 0);

        $this->expectedPaymentDate = $paymentDate;
        $this->expectedTimeframe = $timeframe;
        $this->expectedRequestedAmount = $requestedAmount;

        $this->anticipation = self::getPagarMe()
            ->BulkAnticipation()
            ->create(
                $this->recipient,
                $paymentDate,
                $timeframe,
                $requestedAmount
            );
    }

    /**
     * @Then a anticipation must be created
     */
    public function aAnticipationMustBeCreated()
    {
        assertInstanceOf('PagarMe\Sdk\BulkAnticipation\BulkAnticipation', $this->anticipation);
        assertNotNull($this->anticipation->getId());
    }

    /**
     * @Then must anticipation contain same data
     */
    public function mustAnticipationContainSameData()
    {
        assertEquals($this->expectedPaymentDate, $this->anticipation->getPaymentDate());
        assertEquals($this->expectedTimeframe, $this->anticipation->getTimeframe());
    }
}
