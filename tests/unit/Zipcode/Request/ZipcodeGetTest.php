<?php

namespace PagarMe\SdkTest\Zipcode\Request;

use PagarMe\Sdk\Zipcode\Request\ZipcodeInfoGet;
use PagarMe\Sdk\Request;

class ZipcodeInfoGetTest extends \PHPUnit_Framework_TestCase
{
    const PATH    = 'zipcodes/01034020';
    const ZIPCODE = '01034020';

    /**
     * @test
     */
    public function mustContentBeCorrect()
    {
        $zipcodeInfoGet = new ZipcodeInfoGet(self::ZIPCODE);

        $this->assertEquals([], $zipcodeInfoGet->getPayload());

        $this->assertEquals(Request::HTTP_GET, $zipcodeInfoGet->getMethod());

        $this->assertEquals(self::PATH, $zipcodeInfoGet->getPath());
    }
}
