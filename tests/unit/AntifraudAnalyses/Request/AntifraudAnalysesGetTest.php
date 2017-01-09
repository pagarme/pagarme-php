<?php

namespace PagarMe\SdkTest\AntifraudAnalyses\Request;

use PagarMe\Sdk\AntifraudAnalyses\Request\AntifraudAnalysesGet;
use PagarMe\Sdk\RequestInterface;

class AntifraudAnalysesGetTest extends \PHPUnit_Framework_TestCase
{
    const PATH                  = 'transactions/112233/antifraud_analyses/123';
    const TRANSACTION_ID        = 112233;
    const ANTIFRAUD_ANALYSES_ID = 123;

    /**
     * @test
     */
    public function mustContentBeCorrect()
    {
        $transactionMock = $this->getMockBuilder(
            'PagarMe\Sdk\Transaction\AbstractTransaction'
        )->disableOriginalConstructor()
        ->getMock();

        $transactionMock->method('getId')
            ->willReturn(self::TRANSACTION_ID);

        $antifraudAnalysesGet = new AntifraudAnalysesGet(
            $transactionMock,
            self::ANTIFRAUD_ANALYSES_ID
        );

        $this->assertEquals([], $antifraudAnalysesGet->getPayload());
        $this->assertEquals(
            RequestInterface::HTTP_GET,
            $antifraudAnalysesGet->getMethod()
        );
        $this->assertEquals(self::PATH, $antifraudAnalysesGet->getPath());
    }
}
