<?php

namespace PagarMe\Test;

use PagarMe\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PagarMe\Endpoints\Customers;

final class CustomerTest extends PagarMeTestCase
{
    public function customerProvider()
    {
        return [
            [
                new MockHandler([
                    new Response(200, [], self::jsonMock('CustomerMock'))
                ])
            ]
        ];
    }

    /**
     * @dataProvider customerProvider
     */
    public function testCustomerCreate($mock)
    {
        $requestsContainer = [];
        $handler = self::buildHandler($requestsContainer, $mock);

        $client = new Client('apiKey', ['handler' => $handler]);

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

        $this->assertEquals('/1/customers', self::getRequestUri($requestsContainer));
        $this->assertEquals('POST', self::getRequestMethod($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('CustomerMock'), true));
    }
}
