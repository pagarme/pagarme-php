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
}
