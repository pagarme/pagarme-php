<?php

namespace PagarMe\SdkTest\Request;

use PagarMe\Sdk\Plan\Request\PlanList;
use PagarMe\Sdk\RequestInterface;
use PHPUnit\Framework\TestCase;

class PlanListTest extends TestCase
{
    const PATH   = 'plans';

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
     */
    public function mustContentBeCorrect($page, $count)
    {
        $request = new PlanList($page, $count);

        $this->assertEquals(self::PATH, $request->getPath());
        $this->assertEquals(RequestInterface::HTTP_GET, $request->getMethod());
        $this->assertEquals(
            [
                'page'  => $page,
                'count' => $count
            ],
            $request->getPayload()
        );
    }
}
