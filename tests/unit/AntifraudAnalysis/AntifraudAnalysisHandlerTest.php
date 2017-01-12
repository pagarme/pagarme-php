<?php

namespace PagarMe\SdkTest\AntifraudAnalysis;

use PagarMe\Sdk\AntifraudAnalysis\AntifraudAnalysisHandler;

class AntifraudAnalysisHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function mustSendAnAntifraudAnalysisList()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('send'))
            ->getMock();

        $clientMock->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(
                'PagarMe\Sdk\AntifraudAnalysis\Request\AntifraudAnalysisList'
            ))
            ->willReturn(json_decode('{}'));

        $handler = new AntifraudAnalysisHandler($clientMock);

        $transactionMock = $this->getMockBuilder('PagarMe\Sdk\Transaction\BoletoTransaction')
            ->disableOriginalConstructor()
            ->getMock();

        $antifraudAnalyses = $handler->getList($transactionMock);
    }

    /**
     * @test
     */
    public function mustReturnAnArrayOfAntifraudAnalysis()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('send'))
            ->getMock();

        $clientMock->method('send')
            ->with($this->isInstanceOf(
                'PagarMe\Sdk\AntifraudAnalysis\Request\AntifraudAnalysisList'
            ))->willReturn(json_decode('[{"object":"antifraud_analysis","name":"development","score":null,"cost":0,"status":"failed","date_created":"2017-01-03T21:03:55.922Z","date_updated":"2017-01-03T21:03:55.945Z","id":155174},{"object":"antifraud_analysis","name":"development","score":null,"cost":0,"status":"failed","date_created":"2017-01-03T21:03:55.922Z","date_updated":"2017-01-03T21:03:55.945Z","id":155174}]'));

        $handler = new AntifraudAnalysisHandler($clientMock);

        $transactionMock = $this->getMockBuilder('PagarMe\Sdk\Transaction\BoletoTransaction')
            ->disableOriginalConstructor()
            ->getMock();

        $antifraudAnalyses = $handler->getList($transactionMock);

        $this->assertContainsOnly(
            'PagarMe\Sdk\AntifraudAnalysis\AntifraudAnalysis',
            $antifraudAnalyses
        );
        $this->assertGreaterThanOrEqual(
            1,
            count($antifraudAnalyses)
        );
    }

    /**
     * @test
     */
    public function mustSendAnAntifraudAnalysisGet()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('send'))
            ->getMock();

        $clientMock->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(
                'PagarMe\Sdk\AntifraudAnalysis\Request\AntifraudAnalysisGet'
            ))->willReturn(json_decode('{}'));

        $handler = new AntifraudAnalysisHandler($clientMock);

        $transactionMock = $this->getMockBuilder('PagarMe\Sdk\Transaction\BoletoTransaction')
            ->disableOriginalConstructor()
            ->getMock();

        $antifraudAnalyses = $handler->get($transactionMock, rand(100, 1000));
    }

    /**
     * @test
     */
    public function mustReturnAnAntifraudAnalysis()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('send'))
            ->getMock();

        $clientMock->method('send')
            ->with($this->isInstanceOf(
                'PagarMe\Sdk\AntifraudAnalysis\Request\AntifraudAnalysisGet'
            ))->willReturn(json_decode('{"object":"antifraud_analysis","name":"development","score":null,"cost":0,"status":"failed","date_created":"2017-01-03T21:03:55.922Z","date_updated":"2017-01-03T21:03:55.945Z","id":155174}'));

        $handler = new AntifraudAnalysisHandler($clientMock);

        $transactionMock = $this->getMockBuilder('PagarMe\Sdk\Transaction\BoletoTransaction')
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertInstanceOf(
            'PagarMe\Sdk\AntifraudAnalysis\AntifraudAnalysis',
            $handler->get($transactionMock, rand(1000, 10000))
        );
    }
}
