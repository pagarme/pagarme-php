<?php

namespace PagarMe\SdkTest\BalanceOperations\Request;

use PagarMe\Sdk\BalanceOperations\Request\BalanceOperationsList;

class BalanceOperationsListTest extends \PHPUnit_Framework_TestCase
{
    const PATH            = 'balance/operations';
    const METHOD          = 'GET';

    public function balanceOperationsListParams()
    {
        return [
            [null, null],
            [1, null],
            [null, 2],
            [3, 4],
        ];
    }

    /**
     * @dataProvider balanceOperationsListParams
     * @test
     */
    public function mustContentBeCorrect($page, $count)
    {
        $request = new BalanceOperationsList(
            $page,
            $count
        );

        $this->assertEquals(self::METHOD, $request->getMethod());
        $this->assertEquals(self::PATH, $request->getPath());
        $this->assertEquals(
            [
                'page'  => $page,
                'count' => $count
            ],
            $request->getPayload()
        );
    }
}
