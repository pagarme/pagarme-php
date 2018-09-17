<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Payables;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class PayablesTest extends PagarMeTestCase
{
    public function mockProvider()
    {
        return [[[
            'payable' => new MockHandler([
                new Response(200, [], self::jsonMock('PayableMock'))
            ]),
            'list' => new MockHandler([
                new Response(200, [], self::jsonMock('PayableListMock')),
                new Response(200, [], '[]')
            ])
        ]]];
    }

    /**
     * @dataProvider mockProvider
     */
    public function testPayablesGet($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['payable']);

        $response = $client->payables()->get(['id' => 1234556]);

        $this->assertEquals(
            Payables::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/payables/1234556',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PayableMock')),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testPayablesList($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['list']);

        $response = $client->payables()->getList();
        
        $this->assertEquals(
            Payables::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/payables',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PayableListMock')),
            $response
        );

        $response = $client->payables()->getList([
            'created_at' => '1970-01-01T00:00:00.000Z',
            'amount' => 30000,
            'recipient_id' => 're_abc1234abc1234abc1234abc1'
        ]);

        $query = self::getQueryString($container[1]);

        $this->assertContains('amount=30000', $query);
        $this->assertContains(
            'created_at=1970-01-01T00%3A00%3A00.000Z',
            $query
        );
        $this->assertContains(
            'recipient_id=re_abc1234abc1234abc1234abc1',
            $query
        );
        $this->assertEquals(
            json_decode('[]'),
            $response
        );
    }
}
