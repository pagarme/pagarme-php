<?php

namespace PagarMe\SdkTest\Company\Request;

use PagarMe\Sdk\Company\Request\CompanyInfo;

class CompanyInfoTest extends \PHPUnit_Framework_TestCase
{
    const METHOD = 'GET';
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
            self::METHOD,
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
