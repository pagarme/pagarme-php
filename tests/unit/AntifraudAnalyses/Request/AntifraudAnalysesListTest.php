<?php

namespace PagarMe\SdkTest\AntifraudAnalyses\Request;

use PagarMe\Sdk\AntifraudAnalyses\Request\AntifraudAnalysesList;

class AntifraudAnalysesListTest extends \PHPUnit_Framework_TestCase
{
    const PATH           = 'transactions/112233/antifraud_analyses';
    const METHOD         = 'GET';
    const TRANSACTION_ID = 112233;

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

        $antifraudAnalysesList = new AntifraudAnalysesList($transactionMock);

        $this->assertEquals([], $antifraudAnalysesList->getPayload());
        $this->assertEquals(self::METHOD, $antifraudAnalysesList->getMethod());
        $this->assertEquals(self::PATH, $antifraudAnalysesList->getPath());
    }
}
