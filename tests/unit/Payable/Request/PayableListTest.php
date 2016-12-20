<?php

namespace PagarMe\SdkTest\Payable\Request;

use PagarMe\Sdk\Payable\Request\PayableList;

class PayableListTest extends \PHPUnit_Framework_TestCase
{
    const PATH   = 'payables';
    const METHOD = 'GET';

    public function payableListParams()
    {
        return [
            [null, null],
            [1, null],
            [null, 2],
            [3, 4],
        ];
    }

    /**
     * @dataProvider payableListParams
     * @test
     */
    public function mustContentBeCorrect($page, $count)
    {
        $request = new PayableList($page, $count);

        $this->assertEquals(self::PATH, $request->getPath());
        $this->assertEquals(self::METHOD, $request->getMethod());
        $this->assertEquals(
            [
                'page'  => $page,
                'count' => $count
            ],
            $request->getPayload()
        );
    }
}
