<?php

namespace PagarMe\SdkTest\Transaction\Request;

use PagarMe\Sdk\Transaction\Request\TransactionPay;

class TransactionPayTest extends \PHPUnit_Framework_TestCase
{
    const METHOD = 'PUT';
    const PATH   = 'transactions/1337';
    const TRANSACTION_ID = 1337;

    /**
     * @test
    **/
    public function mustPayloadBeCorrect()
    {
        $transactionMock = $this->getMockBuilder('PagarMe\Sdk\Transaction\BoletoTransaction')
            ->disableOriginalConstructor()
            ->getMock();
        $transactionMock->method('getId')
            ->willReturn(self::TRANSACTION_ID);

        $transactionCreate = new TransactionPay($transactionMock);

        $this->assertEquals(
            [
                'status' => 'paid'
            ],
            $transactionCreate->getPayload()
        );
        $this->assertEquals(self::PATH, $transactionCreate->getPath());
        $this->assertEquals(self::METHOD, $transactionCreate->getMethod());
    }
}
