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
            [null, null, null],
            [1, null, null],
            [null, 2, 'waiting_funds'],
            [3, 4, 'avaliable'],
        ];
    }

    /**
     * @dataProvider balanceOperationsListParams
     * @test
     */
    public function mustContentBeCorrect($page, $count, $status)
    {
        $request = new BalanceOperationsList(
            $page,
            $count,
            $status
        );

        $this->assertEquals(self::METHOD, $request->getMethod());
        $this->assertEquals(self::PATH, $request->getPath());
        $this->assertEquals(
            [
                'page'   => $page,
                'count'  => $count,
                'status' => $status
            ],
            $request->getPayload()
        );
    }
}
