<?php


namespace PagarMe\SdkTest;

use PagarMe\Sdk\PagarMe;

class PagarMeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
    **/
    public function mustReturnCardHandler()
    {
        $pagarMe = new PagarMe('apiKey');
        $this->assertInstanceOf(
            'PagarMe\Sdk\Card\CardHandler',
            $pagarMe->card()
        );
    }

    /**
     * @test
    **/
    public function mustReturnCustomerHandler()
    {
        $pagarMe = new PagarMe('apiKey');
        $this->assertInstanceOf(
            'PagarMe\Sdk\Customer\CustomerHandler',
            $pagarMe->customer()
        );
    }

    /**
     * @test
    **/
    public function mustReturnSameCardHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $cardHandlerA = $pagarMe->card();
        $cardHandlerB = $pagarMe->card();

        $this->assertSame($cardHandlerA, $cardHandlerB);
    }

    /**
     * @test
    **/
    public function mustReturnTransactionHandler()
    {
        $pagarMe = new PagarMe('apiKey');
        $this->assertInstanceOf(
            'PagarMe\Sdk\Transaction\TransactionHandler',
            $pagarMe->transaction()
        );
    }

    /**
     * @test
    **/
    public function mustReturnSameTransactionHandler()
    {
        $pagarMe = new PagarMe('apiKey');
        $transactionHandlerA = $pagarMe->transaction();
        $transactionHandlerB = $pagarMe->transaction();
        $this->assertSame($transactionHandlerA, $transactionHandlerB);
    }

    /**
     * @test
    **/
    public function mustReturnSameCustomerHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $customerHandlerA = $pagarMe->customer();
        $customerHandlerB = $pagarMe->customer();

        $this->assertSame($customerHandlerA, $customerHandlerB);
    }

    /**
     * @test
     **/
    public function mustReturnRecipientsHandler()
    {
        $pagarMe =  new PagarMe('apiKey');

        $this->assertInstanceOf(
            'PagarMe\Sdk\Recipient\RecipientHandler',
            $pagarMe->recipient()
        );
    }

    /**
     * @test
    **/
    public function mustReturnSameRecipientHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $recipientHandlerA = $pagarMe->recipient();
        $recipientHandlerB = $pagarMe->recipient();

        $this->assertSame($recipientHandlerA, $recipientHandlerB);
    }

    /**
     * @test
    **/
    public function mustReturnSamePlanHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $planHandlerA = $pagarMe->plan();
        $planHandlerB = $pagarMe->plan();

        $this->assertSame($planHandlerA, $planHandlerB);
    }

    /**
     * @test
    **/
    public function mustReturnSameSplitRuleHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $splitRuleHandlerA = $pagarMe->splitRule();
        $splitRuleHandlerB = $pagarMe->splitRule();

        $this->assertSame($splitRuleHandlerA, $splitRuleHandlerB);
    }

    /**
     * @test
    **/
    public function mustReturnSameTransferHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $transferHandlerA = $pagarMe->transfer();
        $this->assertInstanceOf(
            'PagarMe\Sdk\Transfer\TransferHandler',
            $transferHandlerA
        );

        $transferHandlerB = $pagarMe->transfer();
        $this->assertSame($transferHandlerA, $transferHandlerB);
    }

    /**
     * @test
    */
    public function mustReturnSameCompanyHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $companyHandlerA = $pagarMe->company();
        $companyHandlerB = $pagarMe->company();

        $this->assertSame($companyHandlerA, $companyHandlerB);
        $this->assertInstanceOf(
            'PagarMe\Sdk\Company\CompanyHandler',
            $companyHandlerA
        );
    }

    /**
     * @test
     */
    public function mustReturnSameBankAccountHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $bankAccountHandlerA = $pagarMe->bankAccount();
        $bankAccountHandlerB = $pagarMe->bankAccount();

        $this->assertSame($bankAccountHandlerA, $bankAccountHandlerB);
        $this->assertInstanceOf(
            'PagarMe\Sdk\BankAccount\BankAccountHandler',
            $bankAccountHandlerA
        );
    }

    /**
     * @test
    **/
    public function mustReturnSameSubscriptionHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $subscriptionHandlerA = $pagarMe->subscription();
        $subscriptionHandlerB = $pagarMe->subscription();

        $this->assertSame($subscriptionHandlerA, $subscriptionHandlerB);
        $this->assertInstanceOf(
            'PagarMe\Sdk\Subscription\SubscriptionHandler',
            $subscriptionHandlerA
        );
    }

    /**
     * @test
    */
    public function mustReturnSameBulkAnticipationHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $bulkAnticipationHandlerA = $pagarMe->bulkAnticipation();
        $bulkAnticipationHandlerB = $pagarMe->bulkAnticipation();

        $this->assertSame($bulkAnticipationHandlerA, $bulkAnticipationHandlerB);
        $this->assertInstanceOf(
            'PagarMe\Sdk\BulkAnticipation\BulkAnticipationHandler',
            $bulkAnticipationHandlerA
        );
    }

    /**
     * @test
    */
    public function mustReturnSamePayableHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $payableHandlerA = $pagarMe->payable();
        $payableHandlerB = $pagarMe->payable();

        $this->assertSame($payableHandlerA, $payableHandlerB);
        $this->assertInstanceOf(
            'PagarMe\Sdk\Payable\PayableHandler',
            $payableHandlerA
        );
    }

    /**
     * @test
    */
    public function mustReturnSameZipcodeHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $zipcodeHandlerA = $pagarMe->zipcode();
        $zipcodeHandlerB = $pagarMe->zipcode();

        $this->assertSame($zipcodeHandlerA, $zipcodeHandlerB);
        $this->assertInstanceOf(
            'PagarMe\Sdk\Zipcode\ZipcodeHandler',
            $zipcodeHandlerA
        );
    }

    /**
     * @test
    */
    public function mustReturnSamePostbackHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $postbackHandlerA = $pagarMe->postback();
        $postbackHandlerB = $pagarMe->postback();

        $this->assertSame($postbackHandlerA, $postbackHandlerB);
        $this->assertInstanceOf(
            'PagarMe\Sdk\Postback\PostbackHandler',
            $postbackHandlerA
        );
    }

    /**
     * @test
    */
    public function mustReturnSameAntifraudAnalysesHandler()
    {
        $pagarMe = new PagarMe('apiKey');

        $antifraudAnalysesHandlerA = $pagarMe->antifraudAnalyses();
        $antifraudAnalysesHandlerB = $pagarMe->antifraudAnalyses();

        $this->assertSame(
            $antifraudAnalysesHandlerA,
            $antifraudAnalysesHandlerB
        );

        $this->assertInstanceOf(
            'PagarMe\Sdk\AntifraudAnalyses\AntifraudAnalysesHandler',
            $antifraudAnalysesHandlerA
        );
    }
}
