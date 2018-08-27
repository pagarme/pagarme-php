<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Cards;
use PagarMe\Test\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
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
        $handler = self::buildHandler($container, $mock['card']);

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
            self::getRequestMethod($container),
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
        $handler = self::buildHandler($container, $mock['cardList']);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->cards()->getList();

        $this->assertEquals(
            self::getRequestMethod($container),
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
        $handler = self::buildHandler($container, $mock['card']);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->cards()->get([
            'id' => 'card_abc1234abc1234abc1234abc1'
        ]);

        $this->assertEquals(
            self::getRequestMethod($container),
            'GET'
        );
        $this->assertEquals(
            self::getRequestUri($container),
            '/1/cards/card_abc1234abc1234abc1234abc1'
        );
        $this->assertEquals(
            $response->getArrayCopy(),
            json_decode(self::jsonMock('CardMock'), true)
        );
    }
}
