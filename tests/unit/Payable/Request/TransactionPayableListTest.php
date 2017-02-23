<?php

namespace PagarMe\SdkTest\Payable\Request;

use PagarMe\Sdk\Payable\Request\TransactionPayableList;
use PagarMe\Sdk\RequestInterface;

class TransactionPayableListTest extends \PHPUnit_Framework_TestCase
{
    const PATH   = 'payables';

    public function payableListParams()
    {
        return [
            [1],
            [null],
            ['ABC']
        ];
    }

    /**
     * @dataProvider payableListParams
     * @test
     */
    public function mustContentBeCorrect($transactionId)
    {
        $request = new TransactionPayableList($transactionId);

        $this->assertEquals(self::PATH, $request->getPath());
        $this->assertEquals(RequestInterface::HTTP_GET, $request->getMethod());
        $this->assertEquals(
            [
                'transaction_id'  => (string)$transactionId,
            ],
            $request->getPayload()
        );
    }
}
