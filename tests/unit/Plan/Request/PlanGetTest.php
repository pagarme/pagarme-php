<?php

namespace PagarMe\SdkTest\Request;

use PagarMe\Sdk\Plan\Request\PlanGet;

class PlanGetTest extends \PHPUnit_Framework_TestCase
{
    const PATH    = 'plans/123';
    const METHOD  = 'GET';
    const PLAN_ID = '123';

    /**
     * @test
    **/
    public function mustContentBeCorrect()
    {
        $request = new PlanGet(self::PLAN_ID);

        $this->assertEquals(self::PATH, $request->getPath());
        $this->assertEquals(self::METHOD, $request->getMethod());
        $this->assertEquals(
            [],
            $request->getPayload()
        );
    }
}
