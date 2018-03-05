<?php

namespace PagarMe\SdkTest\Transaction\Request;

use PagarMe\Sdk\RequestInterface;
use PagarMe\Sdk\Transaction\Request\TransactionPayables;

class TransactionPayablesTest extends \PHPUnit_Framework_TestCase
{
    const PATH           = 'transactions/1337/payables';
    const TRANSACTION_ID = 1337;

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $transactionCreate = new TransactionPayables(self::TRANSACTION_ID);

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
        $transactionCreate = new TransactionPayables(self::TRANSACTION_ID);

        $this->assertEquals(self::PATH, $transactionCreate->getPath());
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $transactionCreate = new TransactionPayables(self::TRANSACTION_ID);

        $this->assertEquals(RequestInterface::HTTP_GET, $transactionCreate->getMethod());
    }
}
