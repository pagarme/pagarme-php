<?php

namespace PagarMe\SdkTest\Zipcode\Request;

use PagarMe\Sdk\Zipcode\Request\ZipcodeInfoGet;

class ZipcodeInfoGetTest extends \PHPUnit_Framework_TestCase
{
    const METHOD      = 'GET';
    const PATH        = 'zipcodes/01034020';
    const ZIPCODE     = '01034020';

    /**
     * @test
     */
    public function mustContentBeCorrect()
    {
        $zipcodeInfoGet = new ZipcodeInfoGet(self::ZIPCODE);

        $this->assertEquals([], $zipcodeInfoGet->getPayload());

        $this->assertEquals(self::METHOD, $zipcodeInfoGet->getMethod());

        $this->assertEquals(self::PATH, $zipcodeInfoGet->getPath());
    }
}
