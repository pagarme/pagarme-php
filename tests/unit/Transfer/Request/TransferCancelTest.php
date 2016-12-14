<?php

namespace PagarMe\SdkTest\Transfer\Request;

use PagarMe\Sdk\Transfer\Request\TransferCancel;

class TransferCancelTest extends \PHPUnit_Framework_TestCase
{
    const METHOD      = 'POST';
    const PATH        = 'transfers/123/cancel';
    const TRANSFER_ID = '123';

    /**
     * @test
     */
    public function mustContentBeCorrect()
    {
        $transferMock = $this->getMockBuilder('PagarMe\Sdk\Transfer\Transfer')
            ->disableOriginalConstructor()
            ->getMock();
        $transferMock->method('getId')->willReturn(self::TRANSFER_ID);

        $transferCancel = new TransferCancel($transferMock);

        $this->assertEquals([], $transferCancel->getPayload());

        $this->assertEquals(self::METHOD, $transferCancel->getMethod());

        $this->assertEquals(self::PATH, $transferCancel->getPath());
    }
}
