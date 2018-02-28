<?php

namespace PagarMe\SdkTest\Transfer\Request;

use PagarMe\Sdk\Transfer\Request\TransferGet;
use PagarMe\Sdk\RequestInterface;
use PHPUnit\Framework\TestCase;

class TransferGetTest extends TestCase
{
    const PATH        = 'transfers/123';
    const TRANSFER_ID = '123';

    /**
     * @test
     */
    public function mustContentBeCorrect()
    {
        $transferGet = new TransferGet(self::TRANSFER_ID);

        $this->assertEquals([], $transferGet->getPayload());

        $this->assertEquals(RequestInterface::HTTP_GET, $transferGet->getMethod());

        $this->assertEquals(self::PATH, $transferGet->getPath());
    }
}
