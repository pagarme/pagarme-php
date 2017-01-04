<?php

namespace PagarMe\SdkTest\Transaction\Request;

use PagarMe\Sdk\Transaction\Request\TransactionGet;
use PagarMe\Sdk\Transaction\CreditCardTransaction;

class TransactionGetTest extends \PHPUnit_Framework_TestCase
{
    const METHOD = 'GET';
    const PATH   = 'transactions/1337';
    const TRANSACTION_ID = 1337;

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $transactionCreate = new TransactionGet(self::TRANSACTION_ID);

        $this->assertEquals(
            [],
            $transactionCreate->getPayload()
        );
    }

    /**
     * @test
     */
    public function mustPathBeCorrect()
    {
        $transactionCreate = new TransactionGet(self::TRANSACTION_ID);

        $this->assertEquals(self::PATH, $transactionCreate->getPath());
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $transactionCreate = new TransactionGet(self::TRANSACTION_ID);

        $this->assertEquals(self::METHOD, $transactionCreate->getMethod());
    }
}
