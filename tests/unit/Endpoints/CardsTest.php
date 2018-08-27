<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Cards;
use PagarMe\Test\PagarMeTestCase;
use GuzzleHttp\Middleware;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class CardsTest extends PagarMeTestCase
{
    public function cardMockProvider()
    {
        return [[[
            'card' => new MockHandler([
                new Response(200, [], self::jsonMock('CardMock'))
            ]),
            'cardList' => new MockHandler([
                new Response(200, [], self::jsonMock('CardListMock'))
            ]),
        ]]];
    }

    /**
     * @dataProvider cardMockProvider
     */
    public function testCardCreate($mock)
    {
        $container = [];
        $history = Middleware::history($container);

        $handler = HandlerStack::create($mock['card']);
        $handler->push($history);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->cards()->create([
            'card_number' => '4111111111111111',
            'card_expiration_date' => '0722',
            'card_cvv' => '123',
            'card_holder_name' => 'Davy Jones',
            'customer_id' => null,
            'card_hash' => null,
        ]);

        $this->assertEquals(
            $container[0]['request']->getMethod(),
            'POST'
        );
        $this->assertEquals(
            $response->getArrayCopy(),
            json_decode(self::jsonMock('CardMock'), true)
        );
    }

    /**
     * @dataProvider cardMockProvider
     */
    public function testCardList($mock)
    {
        $container = [];
        $history = Middleware::history($container);

        $handler = HandlerStack::create($mock['cardList']);
        $handler->push($history);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->cards()->getList();

        $this->assertEquals(
            $container[0]['request']->getMethod(),
            'GET'
        );
        $this->assertEquals(
            $response->getArrayCopy(),
            json_decode(self::jsonMock('CardListMock'), true)
        );
    }

    /**
     * @dataProvider cardMockProvider
     */
    public function testCardGet($mock)
    {
        $container = [];
        $history = Middleware::history($container);

        $handler = HandlerStack::create($mock['card']);
        $handler->push($history);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->cards()->get([
            'id' => 'card_abc1234abc1234abc1234abc1'
        ]);

        $this->assertEquals(
            $container[0]['request']->getMethod(),
            'GET'
        );
        $this->assertEquals(
            $container[0]['request']->getUri()->getPath(),
            '/1/cards/card_abc1234abc1234abc1234abc1'
        );
        $this->assertEquals(
            $response->getArrayCopy(),
            json_decode(self::jsonMock('CardMock'), true)
        );
    }
}
