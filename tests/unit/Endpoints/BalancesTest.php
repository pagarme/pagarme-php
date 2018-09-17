<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Balances;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class BalancesTest extends PagarMeTestCase
{
    public function testBalanceGet()
    {
        $container = [];
        $client = self::buildClient(
            $container,
            new MockHandler([
                new Response(200, [], self::jsonMock('BalanceMock'))
            ])
        );

        $response = $client->balances()->get();

        $this->assertEquals(
            Balances::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/balance',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BalanceMock')),
            $response
        );
    }
}
