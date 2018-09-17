<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Refunds;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

final class RefundsTest extends PagarMeTestCase
{
    public function refundsProvider()
    {
        return [
            [
                new MockHandler([
                    new Response(200, [], self::jsonMock('RefundsMock')),
                    new Response(200, [], '[]')
                ])
            ]
        ];
    }
    /**
     * @dataProvider refundsProvider
     */
    public function testRefundsGetList($mock)
    {
        $requestsContainer = [];

        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->refunds()->getList();

        $this->assertEquals(
            '/1/refunds',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Refunds::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('RefundsMock')),
            $response
        );

        $response = $client->refunds()->getList([
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
