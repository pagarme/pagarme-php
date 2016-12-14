<?php

namespace PagarMe\Acceptance;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\Customer\Customer;
use PagarMe\Sdk\SplitRule\SplitRuleCollection;
use PagarMe\Sdk\Recipient\Recipient;

class TransferContext extends BasicContext
{
    use Helper\CustomerDataProvider;

    private $recipient;
    private $transfer;
    private $amount;
    private $bankAccount;
    private $queryTransfer;

    /**
     * @Given a valid recipient
     */
    public function aValidRecipient()
    {
        $this->recipient = self::getPagarMe()
            ->recipient()
            ->create(
                new BankAccount(
                    [
                        'bank_code'       => '237',
                        'agencia'         => '1935',
                        'agencia_dv'      => '0',
                        'conta'           => '060708',
                        'conta_dv'        => '1',
                        'document_number' => '20487713435',
                        'legal_name'      => 'João Silva'
                    ]
                ),
                'weekly',
                '1',
                true,
                true,
                10
            );
    }


    /**
     * @Given avaliable founds
     */
    public function avaliableFounds()
    {
        $customerData = $this->getValidCustomerData();
        $customer = new Customer($customerData);

        $splitRules = new SplitRuleCollection();
        $splitRules[]= self::getPagarMe()
            ->splitRule()
            ->percentageRule(50, $this->recipient);
        $splitRules[]=self::getPagarMe()
            ->splitRule()
            ->percentageRule(50, $this->getCompanyRecipient());

        $transaction = self::getPagarMe()
            ->transaction()
            ->boletoTransaction(
                100000,
                $customer,
                'https://httpstatusdogs.com/200-ok',
                ['split_rules' => $splitRules]
            );

        $this->transaction = self::getPagarMe()
            ->transaction()
            ->payTransaction($transaction);
    }

    /**
     * @When make tranfer with amount of :amount
     */
    public function makeTranferWithAmountOf($amount)
    {
        $this->amount = $amount;

        $this->transfer = self::getPagarMe()
            ->transfer()
            ->create(
                $this->amount,
                $this->recipient
            );
    }

    /**
     * @When make tranfer with amount of :amount to specific bank account
     */
    public function makeTranferWithAmountOfToSpecificBankAccount($amount)
    {
        $defaultRecipient = self::getPagarMe()
            ->recipient()
            ->get($this->getCompanyRecipient()->getId());

        $this->amount = $amount;

        $this->transfer = self::getPagarMe()
            ->transfer()
            ->create(
                $this->amount,
                $defaultRecipient,
                $defaultRecipient->getBankAccount()->getId()
            );
    }


    /**
     * @Then a transfer must be created
     * @Then a transfer must be returned
     */
    public function mustBeATransfer()
    {
        assertInstanceOf(
            'PagarMe\Sdk\Transfer\Transfer',
            $this->transfer
        );
    }

    /**
     * @Then amount must be the same
     */
    public function amountMustBeTheSame()
    {
        assertEquals(
            $this->amount,
            $this->transfer->getAmount()
        );
    }

    private function getCompanyRecipient()
    {
        $companyInfo = self::getPagarMe()
            ->company()
            ->info();

        $recipientId = $companyInfo->default_recipient_id->test;

        return new Recipient(
            [
                'id' => $recipientId
            ]
        );
    }

     /**
     * @Given a previous created transfer
     */
    public function aPreviousCreatedTransfer()
    {
        $this->aValidRecipient();
        $this->avaliableFounds();
        $this->makeTranferWithAmountOf(rand(200, 5000));
    }

    /**
     * @When I query for the transfer
     */
    public function iQueryForTheTransfer()
    {
        $this->queryTransfer = self::getPagarMe()
            ->transfer()
            ->get($this->transfer->getId());
    }

    /**
     * @Then must be the same transfer
     */
    public function mustBeTheSameTransfer()
    {
        assertEquals(
            $this->transfer,
            $this->queryTransfer
        );
    }
}
