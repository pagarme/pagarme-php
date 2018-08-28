<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Cards;
use PagarMe\Test\Endpoints\PagarMeTestCase;
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
        $client = self::buildClient($container, $mock['card']);

        $response = $client->cards()->create([
            'card_number' => '4111111111111111',
            'card_expiration_date' => '0722',
            'card_cvv' => '123',
            'card_holder_name' => 'Davy Jones',
            'customer_id' => null,
            'card_hash' => null,
        ]);

        $this->assertEquals(
            Cards::POST,
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('CardMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider cardMockProvider
     */
    public function testCardList($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['cardList']);

        $response = $client->cards()->getList();

        $this->assertEquals(
            Cards::GET,
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('CardListMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider cardMockProvider
     */
    public function testCardGet($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['card']);

        $response = $client->cards()->get([
            'id' => 'card_abc1234abc1234abc1234abc1'
        ]);

        $this->assertEquals(
            Cards::GET,
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            '/1/cards/card_abc1234abc1234abc1234abc1',
            self::getRequestUri($container)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('CardMock'), true),
            $response->getArrayCopy()
        );
    }
}
