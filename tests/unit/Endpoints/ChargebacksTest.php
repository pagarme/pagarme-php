<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Chargebacks;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

final class ChargebacksTest extends PagarMeTestCase
{
    public function chargebacksProvider()
    {
        return [
            [
                new MockHandler([
                    new Response(200, [], self::jsonMock('ChargebacksMock')),
                    new Response(200, [], '[]')
                ])
            ]
        ];
    }
    /**
     * @dataProvider chargebacksProvider
     */
    public function testChargebacksGetList($mock)
    {
        $requestsContainer = [];

        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->chargebacks()->getList();

        $this->assertEquals(
            '/1/chargebacks',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Chargebacks::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('ChargebacksMock')),
            $response
        );

        $response = $client->chargebacks()->getList([
            'transaction_id' => 12345,
        ]);

        $query = self::getQueryString($requestsContainer[1]);

        $this->assertContains('transaction_id=12345', $query);
        $this->assertEquals(
            json_decode('[]'),
            $response
        );
    }
}
