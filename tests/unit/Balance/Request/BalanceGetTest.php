<?php

namespace PagarMe\SdkTest\Balance\Request;

use PagarMe\Sdk\Balance\Request\BalanceGet;
use PagarMe\Sdk\RequestInterface;
use PHPUnit\Framework\TestCase;

class BalanceGetTest extends TestCase
{
    const PATH   = 'balance';

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $balanceGet = new BalanceGet();

        $this->assertEquals([], $balanceGet->getPayload());
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $balanceGet = new BalanceGet();

        $this->assertEquals(
            RequestInterface::HTTP_GET,
            $balanceGet->getMethod()
        );
    }

    /**
     * @test
     */
    public function mustMPathBeCorrect()
    {
        $balanceGet = new BalanceGet();

        $this->assertEquals(self::PATH, $balanceGet->getPath());
    }
}
