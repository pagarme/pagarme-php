<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Postbacks;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

final class PostbacksTest extends PagarMeTestCase
{
    public function mockProvider()
    {
        return [[[
            'postback' => new MockHandler([
                new Response(200, [], self::jsonMock('PostbackMock'))
            ]),
            'list' => new MockHandler([
                new Response(200, [], self::jsonMock('PostbackListMock'))
            ])
        ]]];
    }

    /**
     * @dataProvider mockProvider
     */
    public function testRedeliver($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['postback']);

        $response = $client->postbacks()->redeliver([
            'model' => 'transactions',
            'postback_id' => 123456,
            'model_id' => 654321
        ]);

        $this->assertEquals(
            '/1/transactions/654321/postbacks/123456/redeliver',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            Postbacks::POST,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PostbackMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testPostbackList($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['list']);

        $response = $client->postbacks()->getList([
            'model' => 'transactions',
            'model_id' => 654321
        ]);

        $this->assertEquals(
            '/1/transactions/654321/postbacks',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            Postbacks::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PostbackListMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testPostbackGet($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['postback']);

        $response = $client->postbacks()->get([
            'model' => 'transactions',
            'model_id' => 162534,
            'postback_id' => 'po_abc1234abc1234abc1234abc1'
        ]);

        $this->assertEquals(
            '/1/transactions/162534/postbacks/po_abc1234abc1234abc1234abc1',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            Postbacks::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PostbackMock'), true),
            $response->getArrayCopy()
        );
    }
}
