<?php

namespace PagarMe\SdkTest\Transfer\Request;

use PagarMe\Sdk\Transfer\Request\TransferGet;

class TransferGetTest extends \PHPUnit_Framework_TestCase
{
    const METHOD      = 'GET';
    const PATH        = 'transfers/123';
    const TRANSFER_ID = '123';

    /**
     * @test
     */
    public function mustContentBeCorrect()
    {
        $transferGet = new TransferGet(self::TRANSFER_ID);

        $this->assertEquals([], $transferGet->getPayload());

        $this->assertEquals(self::METHOD, $transferGet->getMethod());

        $this->assertEquals(self::PATH, $transferGet->getPath());
    }
}
