<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Transfers;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class TransfersTest extends PagarMeTestCase
{
    public function mockProvider()
    {
        return [[[
            'transfer' => new MockHandler([
                new Response(200, [], self::jsonMock('TransferMock'))
            ]),
            'list' => new MockHandler([
                new Response(200, [], self::jsonMock('TransferListMock')),
                new Response(200, [], '[]')
            ]),
        ]]];
    }

    /**
     * @dataProvider mockProvider
     */
    public function testTransferCreate($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['transfer']);

        $response = $client->transfers()->create([
            'amount' => 10000,
            'recipient_id' => '',
            'metadata' => [
                'foo' => 'bar'
            ]
        ]);

        $this->assertEquals(
            Transfers::POST,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/transfers',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransferMock')),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testTransferList($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['list']);

        $response = $client->transfers()->getList();

        $this->assertEquals(
            Transfers::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/transfers',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransferListMock')),
            $response
        );

        $response = $client->transfers()->getList([
            'bank_account_id' => 1234,
            'amount' => 10000,
            'recipient_id' => 're_abc1234abc1234abc1234abc1'
        ]);

        $query = self::getQueryString($container[1]);

        $this->assertContains('bank_account_id=1234', $query);
        $this->assertContains('amount=10000', $query);
        $this->assertContains(
            'recipient_id=re_abc1234abc1234abc1234abc1',
            $query
        );

        $this->assertEquals(
            json_decode('[]'),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testTransferGet($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['transfer']);

        $response = $client->transfers()->get([
            'id' => 123456
        ]);

        $this->assertEquals(
            Transfers::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/transfers/123456',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransferMock')),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testTransferCancel($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['transfer']);

        $response = $client->transfers()->cancel([
            'id' => 123456
        ]);

        $this->assertEquals(
            Transfers::POST,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/transfers/123456/cancel',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransferMock')),
            $response
        );
    }
}
