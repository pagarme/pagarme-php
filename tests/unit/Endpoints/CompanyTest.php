<?php

namespace PagarMe\Test\Endpoints\Test;

use PagarMe\Endpoints\Company;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PagarMe\Test\Endpoints\PagarMeTestCase;

class CompanyTest extends PagarMeTestCase
{
    public function testCompanyGet()
    {
        $container = [];
        $client = self::buildClient(
            $container,
            new MockHandler([
                new Response(200, [], self::jsonMock('CompanyMock'))
            ])
        );

        $response = $client->company()->get();

        $this->assertEquals(
            Company::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/company',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('CompanyMock')),
            $response
        );
    }
}
