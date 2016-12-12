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

class TransferContext extends BasicContext
{
    use Helper\CustomerDataProvider;

    private $recipient;
    private $transfer;
    private $amount;

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

        $transaction = self::getPagarMe()
            ->transaction()
            ->boletoTransaction(
                100000,
                $customer,
                'https://httpstatusdogs.com/200-ok'
            );

        $this->transaction = self::getPagarMe()
            ->transaction()
            ->payTransaction($transaction);
        sleep(3);
    }


    /**
     * @When make transaction with recipient and amount of :amount
     */
    public function makeTransactionWithRecipientAndAmountOf($amount)
    {
        $this->$amount = $amount;
        $this->transfer = self::getPagarMe()
            ->transfer()
            ->createToRecipient($amount, $this->recipient);
    }

    /**
     * @Then a transfer must be created
     */
    public function aTransferMustBeCreated()
    {
        assertInstanceOf(
            'PagarMe\Sdk\Transfer\Trasnfer',
            $this->transfer
        );
    }

    /**
     * @Then amount must be the same
     */
    public function amountMustBeTheSame()
    {
        throw new PendingException();
    }
}
