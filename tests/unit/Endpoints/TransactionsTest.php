<?php

namespace PagarMe\Test\Endpoints;

use PagarMe\Client;
use PagarMe\Endpoints\Transactions;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

final class TransactionTest extends PagarMeTestCase
{
    public function transactionProvider()
    {
        return [[[
            'transaction' => new MockHandler([
                new Response(200, [], self::jsonMock('TransactionMock'))
            ]),
            'list' => new MockHandler([
                new Response(200, [], self::jsonMock('TransactionListMock')),
                new Response(200, [], '[]')
            ]),
            'payableList' => new MockHandler([
                new Response(200, [], self::jsonMock('PayableListMock'))
            ]),
            'payable' => new MockHandler([
                new Response(200, [], self::jsonMock('PayableMock'))
            ]),
            'operations' => new MockHandler([
                new Response(200, [], self::jsonMock('OperationListMock'))
            ]),
            'events' => new MockHandler([
                new Response(200, [], self::jsonMock('EventListMock'))
            ])
        ]]];
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionCreate($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['transaction']);

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

        $this->assertEquals(
            Transactions::POST,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            '/1/transactions',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransactionMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionList($mock)
    {
        $requestsContainer = [];

        $client = self::buildClient($requestsContainer, $mock['list']);

        $response = $client->transactions()->getList();

        $this->assertEquals(
            Transactions::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            '/1/transactions',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransactionListMock'), true),
            $response->getArrayCopy()
        );

        $response = $client->transactions()->getList([
            'nsu' => 'ABC1234',
            'amount' => 15000,
            'tid' => '2345678'
        ]);

        $query = self::getQueryString($requestsContainer[1]);

        $this->assertContains('nsu=ABC1234', $query);
        $this->assertContains('amount=15000', $query);
        $this->assertContains('tid=2345678', $query);

        $this->assertEquals(
            json_decode('[]', true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionFind($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['transaction']);

        $response = $client->transactions()->get(['id' => 1]);

        $this->assertEquals(
            Transactions::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            '/1/transactions/1',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransactionMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionCapture($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['transaction']);

        $response = $client->transactions()->capture([
            'id' => 1,
            'amount' => 100
        ]);

        $this->assertEquals(
            '/1/transactions/1/capture',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Transactions::POST,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransactionMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionRefund($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['transaction']);

        $response = $client->transactions()->refund([
            'id' => 1,
            'amount' => 100
        ]);

        $this->assertEquals(
            '/1/transactions/1/refund',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Transactions::POST,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('TransactionMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionPayablesList($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['payableList']);

        $response = $client->transactions()->listPayables([
            'id' => 1,
        ]);

        $this->assertEquals(
            '/1/transactions/1/payables',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Transactions::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PayableListMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionGetPayable($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['payable']);

        $response = $client->transactions()->getPayable([
            'transaction_id' => 12345678,
            'payable_id' => 87654321
        ]);

        $this->assertEquals(
            '/1/transactions/12345678/payables/87654321',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Transactions::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PayableMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionOperationsList($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['operations']);

        $response = $client->transactions()->listOperations([
            'id' => 12345678,
        ]);

        $this->assertEquals(
            '/1/transactions/12345678/operations',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Transactions::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('OperationListMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionCollectPayment($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['transaction']);

        $response = $client->transactions()->collectPayment([
            'id' => 12345678,
            'email' => 'teste@email.com'
        ]);

        $this->assertEquals(
            Transactions::POST,
            self::getRequestMethod($requestsContainer[0])
        );

        $this->assertEquals(
            '/1/transactions/12345678/collect_payment',
            self::getRequestUri($requestsContainer[0])
        );

        $this->assertContains(
            '"email":"teste@email.com"',
            self::getBody($requestsContainer[0])
        );

        $this->assertEquals(
            json_decode(self::jsonMock('TransactionMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionEvents($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['events']);

        $response = $client->transactions()->events([
            'id' => 12345678,
        ]);

        $this->assertEquals(
            '/1/transactions/12345678/events',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Transactions::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('EventListMock'), true),
            $response->getArrayCopy()
        );
    }
}
