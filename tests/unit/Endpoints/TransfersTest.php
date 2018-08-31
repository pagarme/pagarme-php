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
                new Response(200, [], self::jsonMock('TransferListMock'))
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
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            '/1/transfers',
            self::getRequestUri($container)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransferMock'), true),
            $response->getArrayCopy()
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
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            '/1/transfers',
            self::getRequestUri($container)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransferListMock'), true),
            $response->getArrayCopy()
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
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            '/1/transfers/123456',
            self::getRequestUri($container)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransferMock'), true),
            $response->getArrayCopy()
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
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            '/1/transfers/123456/cancel',
            self::getRequestUri($container)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransferMock'), true),
            $response->getArrayCopy()
        );
    }
}
