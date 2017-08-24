<?php

namespace PagarMe\SdkTest\Transaction\Request;

use PagarMe\Sdk\Transaction\Request\CreditCardTransactionRefund;
use PagarMe\Sdk\Transaction\CreditCardTransaction;
use PagarMe\Sdk\RequestInterface;

class CreditCardTransactionRefundTest extends \PHPUnit_Framework_TestCase
{
    const PATH           = 'transactions/1337/refund';
    const TRANSACTION_ID = 1337;

    public function refundAmountProvider()
    {
        return [
            [null, true],
            [1000, true],
            [300, true],
            [5050, true],

            [null, false],
            [1000, false],
            [300, false],
            [5050, false],
        ];
    }

    /**
     * @dataProvider refundAmountProvider
     * @test
     */
    public function mustContentBeCorrect($amount, $async)
    {
        $transactionCreate = new CreditCardTransactionRefund(
            $this->getTransactionMock(),
            $amount,
	        $async
        );

        $this->assertEquals(
            [
	            'amount' => $amount,
	            'async' => $async,
            ],
            $transactionCreate->getPayload()
        );

        $this->assertEquals(
            sprintf(self::PATH, self::TRANSACTION_ID),
            $transactionCreate->getPath()
        );

        $this->assertEquals(RequestInterface::HTTP_POST, $transactionCreate->getMethod());
    }

    private function getTransactionMock()
    {
        $transactionMock = $this->getMockBuilder('PagarMe\Sdk\Transaction\CreditCardTransaction')
            ->disableOriginalConstructor()
            ->getMock();

        $transactionMock->method('getId')->willReturn(self::TRANSACTION_ID);

        return $transactionMock;
    }
}
