<?php

namespace PagarMe\SdkTest\Company\Request;

use PagarMe\Sdk\Company\Request\CompanyInfo;
use PagarMe\Sdk\Request;

class CompanyInfoTest extends \PHPUnit_Framework_TestCase
{
    const PATH   = 'company';

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $companyInfo = new CompanyInfo();

        $this->assertEquals(
            [],
            $companyInfo->getPayload()
        );
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $companyInfo = new CompanyInfo();

        $this->assertEquals(
            Request::HTTP_GET,
            $companyInfo->getMethod()
        );
    }

    /**
     * @test
     */
    public function mustMPathBeCorrect()
    {
        $companyInfo = new CompanyInfo();

        $this->assertEquals(
            self::PATH,
            $companyInfo->getPath()
        );
    }
}
