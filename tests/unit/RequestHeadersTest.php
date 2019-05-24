<?php

namespace PagarMe\SdkTest;

use PagarMe\Sdk\RequestHeaders;
use PagarMe\Sdk\PagarMe;

class RequestHeadersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function mustReturnCorrectHeaders()
    {
        $requestHeaders = new RequestHeaders();
        $defaultHeaders = $requestHeaders->getSdkHeaders([]);
        $expectedUserAgent = sprintf(
            'pagarme-php/%s',
            PagarMe::VERSION
        );
        $expectedHeaders = [
            'X-PagarMe-User-Agent' => $expectedUserAgent,
            'User-Agent' => $expectedUserAgent
        ];

        $this->assertEquals($defaultHeaders, $expectedHeaders);

        $filledHeaders = [
            'X-PagarMe-User-Agent' => 'Magento/1.9.1.0',
            'User-Agent' => 'Magento/1.9.1.0'
        ];

        $sdkHeadersFilled = $requestHeaders->getSdkHeaders($filledHeaders);

        $expectedUserAgent = sprintf(
            'Magento/1.9.1.0 pagarme-php/%s',
            PagarMe::VERSION
        );
        $expectedHeaders = [
            'X-PagarMe-User-Agent' => $expectedUserAgent,
            'User-Agent' => $expectedUserAgent
        ];

        $this->assertEquals($sdkHeadersFilled, $expectedHeaders);
    }
}
