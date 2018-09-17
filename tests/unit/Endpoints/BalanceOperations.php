<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\BalanceOperations;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class BalanceOperationsTest extends PagarMeTestCase
{
    public function mockProvider()
    {
        return [[[
            'balanceOperations' => new MockHandler([
                new Response(200, [], self::jsonMock('BalanceOperationsMock'))
            ]),
            'list' => new MockHandler([
                new Response(200, [], self::jsonMock('BalanceOperationsListMock')),
                new Response(200, [], '[]')
            ])
        ]]];
    }

    /**
     * @dataProvider mockProvider
     */
    public function testBalanceOperationsGet($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['balanceOperations']);

        $response = $client->balanceOperations()->get(['id' => 9876342]);

        $this->assertEquals(
            BalanceOperations::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/balance/operations/9876342',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BalanceOperationsMock')),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testBalanceOperationsList($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['list']);

        $response = $client->balanceOperations()->getList();
        
        $this->assertEquals(
            BalanceOperations::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/balance/operations',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BalanceOperationsListMock')),
            $response
        );

        $response = $client->balanceOperations()->getList([
            'amount' => 2000,
            'status' => 'available'
        ]);

        $query = self::getQueryString($container[1]);

        $this->assertContains('amount=30000', $query);
        $this->assertContains(
            'amount=2000',
            $query
        );
        $this->assertContains(
            'status=available',
            $query
        );
        $this->assertEquals(
            json_decode('[]'),
            $response
        );
    }
}
