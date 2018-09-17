<?php

namespace PagarMe\Test\Endpoints;

use PagarMe\Client;
use PagarMe\Endpoints\Customers;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

final class CustomerTest extends PagarMeTestCase
{
    public function customerProvider()
    {
        return [[[
            'customer' => new MockHandler([
                new Response(200, [], self::jsonMock('CustomerMock'))
            ]),
            'list' => new MockHandler([
                new Response(200, [], self::jsonMock('CustomerListMock')),
                new Response(200, [], '[]')
            ])
        ]]];
    }

    /**
     * @dataProvider customerProvider
     */
    public function testCustomerCreate($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['customer']);

        $response = $client->customers()->create([
            'external_id' => '#123456789',
            'name' => 'João das Neves',
            'type' => 'individual',
            'country' => 'br',
            'email' => 'joaoneves@norte.com',
            'documents' => [
                [
                    'type' => 'cpf',
                    'number' => '11111111111'
                ]
            ],
            'phone_numbers' => [
                '+5511999999999',
                '+5511888888888'
            ],
            'birthday' => '1985-01-01'
        ]);

        $this->assertEquals(
            '/1/customers',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Customers::POST,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('CustomerMock')),
            $response
        );
    }

    /**
     * @dataProvider customerProvider
     */
    public function testCustomerGetList($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['list']);

        $response = $client->customers()->getList();
        
        $this->assertEquals(
            '/1/customers',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Customers::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('CustomerListMock')),
            $response
        );

        $response = $client->customers()->getList([
            'name' => 'Fulano da Silva',
            'email' => 'fulano@silva.com',
            'id' => '123456'
        ]);

        $query = self::getQueryString($requestsContainer[1]);

        $this->assertContains('name=Fulano%20da%20Silva', $query);
        $this->assertContains('email=fulano%40silva.com', $query);
        $this->assertContains('id=123456', $query);
        $this->assertEquals(
            json_decode('[]'),
            $response
        );
    }

    /**
     * @dataProvider customerProvider
     */
    public function testCustomerGet($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['customer']);

        $response = $client->customers()->get(['id' => 1]);

        $this->assertEquals(
            '/1/customers/1',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Customers::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('CustomerMock')),
            $response
        );
    }
}
