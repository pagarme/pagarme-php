<?php

namespace PagarMe\SdkTest\Request;

use PagarMe\Sdk\Plan\Request\PlanList;

class PlanListTest extends \PHPUnit_Framework_TestCase
{
    const PATH   = 'plans';
    const METHOD = 'GET';

    public function planListParams()
    {
        return [
            [null, null],
            [1, null],
            [null, 2],
            [3, 4],
        ];
    }

    /**
     * @dataProvider planListParams
     * @test
    **/
    public function mustContentBeCorrect($page, $count)
    {
        $request = new PlanList($page, $count);

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
