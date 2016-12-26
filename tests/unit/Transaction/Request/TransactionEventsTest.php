<?php

namespace PagarMe\SdkTest\Transaction\Request;

use PagarMe\Sdk\Transaction\Request\TransactionEvents;

class TransactionEventsTest extends \PHPUnit_Framework_TestCase
{
    const METHOD         = 'GET';
    const PATH           = 'transactions/1337/events';
    const TRANSACTION_ID = 1337;

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $transactionMock = $this->getMockBuilder('PagarMe\Sdk\Transaction\AbstractTransaction')
            ->disableOriginalConstructor()
            ->getMock();
        $transactionMock->method('getId')
            ->willReturn(self::TRANSACTION_ID);

        $transactionCreate = new TransactionEvents($transactionMock);

        $this->assertEquals(
            [],
            $transactionCreate->getPayload()
        );
        $this->assertEquals(self::PATH, $transactionCreate->getPath());
        $this->assertEquals(self::METHOD, $transactionCreate->getMethod());
    }
}
