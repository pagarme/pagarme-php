<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\PaymentLinks;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class PaymentLinksTest extends PagarMeTestCase
{
    public function mockProvider()
    {
        return [[[
            'link' => new MockHandler([
                new Response(200, [], self::jsonMock('PaymentLinkMock'))
            ]),
            'list' => new MockHandler([
                new Response(200, [], self::jsonMock('PaymentLinkListMock')),
                new Response(200, [], '[]')
            ]),
        ]]];
    }

    /**
     * @dataProvider mockProvider
     */
    public function testPaymentLinkCreate($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['link']);

        $response = $client->paymentLinks()->create([
            'amount' => 10000,
            'items' => [
                [
                    'id' => '1',
                    'title' => "Fighter's Sword",
                    'unit_price' => 4000,
                    'quantity' => 1,
                    'tangible' => true,
                    'category' => 'weapon',
                    'venue' => 'A Link To The Past',
                    'date' => '1991-11-21'
                ],
                [
                    'id' => '2',
                    'title' => 'Kokiri Sword',
                    'unit_price' => 6000,
                    'quantity' => 1,
                    'tangible' => true,
                    'category' => 'weapon',
                    'venue' => "Majora's Mask",
                    'date' => '2000-04-27'
                ],
            ],
            'payment_config' => [
                'boleto' => [
                    'enabled' => true,
                    'expires_in' => 20
                ],
                'credit_card' => [
                    'enabled' => true,
                    'free_installments' => 4,
                    'interest_rate' => 25,
                    'max_installments' => 12
                ],
                'default_payment_method' => 'boleto'
            ],
            'max_orders' => 1,
            'expires_in' => 60
        ]);

        $this->assertEquals(
            PaymentLinks::POST,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/payment_links',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PaymentLinkMock')),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testPaymentLinkList($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['list']);

        $response = $client->paymentLinks()->getList();

        $this->assertEquals(
            PaymentLinks::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/payment_links',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PaymentLinkListMock')),
            $response
        );

        $response = $client->paymentLinks()->getList([
            'short_id' => 'aBcDeFgHiJ'
        ]);

        $this->assertContains(
            'short_id=aBcDeFgHiJ',
            self::getQueryString($container[1])
        );
        $this->assertEquals(
            json_decode('[]'),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testPaymentLinkGet($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['link']);

        $response = $client->paymentLinks()->get([
            'id' => 'pl_abc1234abc1234abc1234abc1'
        ]);

        $this->assertEquals(
            PaymentLinks::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/payment_links/pl_abc1234abc1234abc1234abc1',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PaymentLinkMock')),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testPaymentLinkCancel($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['link']);

        $response = $client->paymentLinks()->cancel([
            'id' => 'pl_abc1234abc1234abc1234abc1'
        ]);

        $this->assertEquals(
            PaymentLinks::POST,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/payment_links/pl_abc1234abc1234abc1234abc1/cancel',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PaymentLinkMock')),
            $response
        );
    }
}
