<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Subscriptions;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class SubscriptionsTest extends PagarMeTestCase
{
    public function mockProvider()
    {
        return [[[
            'subscription' => new MockHandler([
                new Response(200, [], self::jsonMock('SubscriptionMock'))
            ]),
            'list' => new MockHandler([
                new Response(200, [], self::jsonMock('SubscriptionListMock')),
                new Response(200, [], '[]')
            ]),
            'transactions' => new MockHandler([
                new Response(200, [], self::jsonMock('TransactionListMock')),
                new Response(200, [], '[]')
            ]),
        ]]];
    }

    /**
     * @dataProvider mockProvider
     */
    public function testSubscriptionCreate($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['subscription']);

        $response = $client->subscriptions()->create([
            'plan_id' => 123456,
            'payment_method' => 'credit_card',
            'card_number' => '4111111111111111',
            'card_holder_name' => 'UNIX TIME',
            'card_expiration_date' => '0722',
            'card_cvv' => '123',
            'postback_url' => 'http://www.pudim.com.br',
            'customer' => [
                'email' => 'time@unix.com',
                'name' => 'Unix Time',
                'document_number' => '11122233344',
                'address' => [
                    'street' => 'Rua de Teste',
                    'street_number' => '100',
                    'complementary' => 'Apto 666',
                    'neighborhood' => 'Bairro de Teste',
                    'zipcode' => '12345678'
                ],
                'phone' => [
                    'ddd' => '01',
                    'number' => '923456780'
                ],
                'sex' => 'other',
                'born_at' => '1970-01-01',
            ],
            'metadata' => [
                'foo' => 'bar'
            ]
        ]);

        $this->assertEquals(
            Subscriptions::POST,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/subscriptions',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('SubscriptionMock')),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testSubscriptionGet($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['subscription']);

        $response = $client->subscriptions()->get(['id' => 123456]);

        $this->assertEquals(
            Subscriptions::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/subscriptions/123456',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('SubscriptionMock')),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testSubscriptionGetList($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['list']);

        $response = $client->subscriptions()->getList();
        
        $this->assertEquals(
            Subscriptions::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/subscriptions',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('SubscriptionListMock')),
            $response
        );

        $response = $client->subscriptions()->getList([
            'plan_id' => 1234,
            'postback_url' => 'http://www.pudim.com.br',
            'payment_method' => 'credit_card'
        ]);

        $query = self::getQueryString($container[1]);

        $this->assertContains('plan_id=1234', $query);
        $this->assertContains(
            'postback_url=http%3A%2F%2Fwww.pudim.com.br',
            $query
        );
        $this->assertContains('payment_method=credit_card', $query);

        $this->assertEquals(
            json_decode('[]'),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testSubscriptionUpdate($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['subscription']);

        $response = $client->subscriptions()->update([
            'id' => 1234,
            'plan_id' => 4321,
            'payment_method' => 'boleto'
        ]);

        $this->assertEquals(
            Subscriptions::PUT,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/subscriptions/1234',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('SubscriptionMock')),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testSubscriptionCancel($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['subscription']);

        $response = $client->subscriptions()->cancel([
            'id' => 12345
        ]);

        $this->assertEquals(
            Subscriptions::POST,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/subscriptions/12345/cancel',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('SubscriptionMock')),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testSubscriptionTransactions($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['transactions']);

        $response = $client->subscriptions()->transactions([
            'subscription_id' => 1245
        ]);

        $this->assertEquals(
            Subscriptions::GET,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/subscriptions/1245/transactions',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransactionListMock')),
            $response
        );

        $response = $client->subscriptions()->transactions([
            'subscription_id' => 1245,
            'status' => 'paid',
            'amount' => 15000,
            'tid' => 162534
        ]);

        $query = self::getQueryString($container[1]);

        $this->assertContains('status=paid', $query);
        $this->assertContains('amount=15000', $query);
        $this->assertContains('tid=162534', $query);

        $this->assertEquals(
            json_decode('[]'),
            $response
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testSubscriptionSettles($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['subscription']);

        $response = $client->subscriptions()->settleCharges([
            'id' => 12345,
            'charges' => 5
        ]);

        $this->assertEquals(
            Subscriptions::POST,
            self::getRequestMethod($container[0])
        );
        $this->assertEquals(
            '/1/subscriptions/12345/settle_charge',
            self::getRequestUri($container[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('SubscriptionMock')),
            $response
        );
    }
}
