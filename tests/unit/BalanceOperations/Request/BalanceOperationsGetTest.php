<?php

namespace PagarMe\SdkTest\BalanceOperations\Request;

use PagarMe\Sdk\BalanceOperations\Request\BalanceOperationsGet;

class BalanceOperationsGetTest extends \PHPUnit_Framework_TestCase
{
    const PATH                  = 'balance/operations/123';
    const METHOD                = 'GET';
    const BALANCE_OPERATIONS_ID = '123';

    /**
     * @test
     */
    public function mustContentBeCorrect()
    {
        $request = new BalanceOperationsGet(self::BALANCE_OPERATIONS_ID);

        $this->assertEquals(self::METHOD, $request->getMethod());
        $this->assertEquals(self::PATH, $request->getPath());
        $this->assertEquals([], $request->getPayload());
    }
}
