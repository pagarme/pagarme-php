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
    private $expectedStatus;
    private $expectedTimeframe;
    private $expectedRequestedAmount;

    /**
     * @Given a recipient with anticipatable volume
     */
    public function aRecipientWithAnticipatableVolume()
    {
        $recipients = self::getPagarMe()->recipient()->getList();

        $recipients[0]->setAnticipatableVolumePercentage(100);

        $this->recipient = self::getPagarMe()->recipient()->update($recipients[0]);
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
     * @When register a anticipation with :paymentDate, :timeframe, :requestedAmount, :build
     */
    public function registerAAnticipationWith($paymentDate, $timeframe, $requestedAmount, $build)
    {
        $paymentDate = new \Datetime($paymentDate);

        $this->expectedPaymentDate = $paymentDate;
        $this->expectedTimeframe = $timeframe;
        $this->expectedRequestedAmount = $requestedAmount;
        $this->expectedStatus = ($build) ? 'building' : 'pending';

        $this->anticipation = self::getPagarMe()
            ->BulkAnticipation()
            ->create(
                $this->recipient,
                $paymentDate,
                $timeframe,
                $requestedAmount,
                $build
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
        assertEquals($this->anticipation->getPaymentDate(), $this->expectedPaymentDate);
        assertEquals($this->anticipation->getTimeframe(), $this->expectedTimeframe);
        assertEquals($this->anticipation->getAmount(), $this->expectedRequestedAmount);
        assertEquals($this->anticipation->getStatus(), $this->expectedStatus);
    }
}
