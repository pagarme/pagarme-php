<?php

namespace PagarMe\Acceptance;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use PagarMe\Sdk\Customer\Customer;

class AntifraudAnalysisContext extends BasicContext
{
    use Helper\CustomerDataProvider;

    private $transaction;
    private $analyses;

    /**
     * @Given a previous created transaction
     */
    public function aPreviousCreatedTransaction()
    {
        $creditCard = self::getPagarMe()
            ->card()
            ->create('5166190508027271', 'Joao Silva', '1223');

        $customerData = $this->getValidCustomerData();
        $customer = new Customer($customerData);

        $this->transaction = self::getPagarMe()
            ->transaction()
            ->creditCardTransaction(
                1337,
                $creditCard,
                $customer,
                rand(2, 12),
                true,
                'http://eduardo.com'
            );
    }

    /**
     * @When I query transaction antifraud analysis
     */
    public function iQueryTransactionAntifraudAnalysis()
    {
        $this->analyses = self::getPagarMe()
            ->antifraudAnalyses()
            ->getList($this->transaction);
    }

    /**
     * @Then a array of Antifraud Analyses must be returned
     */
    public function aArrayOfAntifraudAnalysesMustBeReturned()
    {
        assertContainsOnly(
            'PagarMe\Sdk\AntifraudAnalyses\AntifraudAnalysis',
            $this->analyses
        );
        assertGreaterThanOrEqual(1, $this->analyses);
    }
}
