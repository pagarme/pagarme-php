<?php

namespace PagarMe\Test\Endpoints;

use PagarMe\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PagarMe\Endpoints\Endpoint;
use PagarMe\Endpoints\Transactions;

final class TransactionTest extends PagarMeTestCase
{
    private static function mock($mockName)
    {
        return file_get_contents("tests/unit/Mocks/$mockName.json");
    }

    public function transactionProvider()
    {
        return [
            [
                new MockHandler([
                    new Response(200, [], self::jsonMock('TransactionMock'))
                ])
            ]
        ];
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionCreate($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->transactions()->create([
            'amount' => 1000,
            'card_number' => '4111111111111111',
            'card_cvv' => '123',
            'card_expiration_date' => '0922',
            'card_holder_name' => 'John Doe',
            'payment_method' => 'credit_card',
            'customer' => [
                'external_id' => '1',
                'name' => 'John Doe',
                'type' => 'individual',
                'country' => 'br',
                'documents' => [[
                    'type' => 'cpf',
                    'number' => '00000000000'
                ]],
                'phone_numbers' => ['+551199999999'],
                'email' => 'aardvark.silva@pagar.me'
            ],
            'billing' => [
                'name' => 'John Doe',
                'address' => [
                    'country' => 'br',
                    'street' => 'Avenida Brigadeiro Faria Lima',
                    'street_number' => '1811',
                    'state' => 'sp',
                    'city' => 'Sao Paulo',
                    'neighborhood' => 'Jardim Paulistano',
                    'zipcode' => '01451001'
                ]
            ],
            'items' => [
                [
                    'id' => 'r123',
                    'title' => 'Red pill',
                    'unit_price' => 10000,
                    'quantity' => 1,
                    'tangible' => true
                ],
                [
                    'id' => 'b123',
                    'title' => 'Blue pill',
                    'unit_price' => 10000,
                    'quantity' => 1,
                    'tangible' => true
                ]
            ]
        ]);

        $this->assertEquals(Endpoint::POST, self::getRequestMethod($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('TransactionMock'), true));
    }

    public function testTransactionList()
    {
        $requestsContainer = [];

        $mock = new MockHandler([
            new Response(200, [], self::jsonMock('TransactionListMock'))
        ]);

        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->transactions()->getList();

        $this->assertEquals(Endpoint::GET, self::getRequestMethod($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('TransactionListMock'), true));
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionFind($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->transactions()->get(['id' => 1]);

        $this->assertEquals(Endpoint::GET, self::getRequestMethod($requestsContainer));
        $this->assertEquals('/1/transactions/1', self::getRequestUri($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('TransactionMock'), true));
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionCapture($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->transactions()->capture(['id' => 1, 'amount' => 100]);

        $this->assertEquals('/1/transactions/1/capture', self::getRequestUri($requestsContainer));
        $this->assertEquals(Endpoint::POST, self::getRequestMethod($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('TransactionMock'), true));
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionRefund($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->transactions()->refund(['id' => 1, 'amount' => 100]);

        $this->assertEquals('/1/transactions/1/refund', self::getRequestUri($requestsContainer));
        $this->assertEquals(Endpoint::POST, self::getRequestMethod($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('TransactionMock'), true));
    }
}
