<?php

namespace PagarMe\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Transactions;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PagarMe\Test\Mocks\TransactionMock;
use PagarMe\Test\Mocks\TransactionListMock;

final class TransactionTest extends TestCase
{
    public function testTransactionCreate()
    {
        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(200, [], TransactionMock::mock())
        ]);

        $handler = HandlerStack::create($mock);
        $handler->push($history);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->transactions()->create([
            "amount" => 1000,
            "card_number" => "4111111111111111",
            "card_cvv" => "123",
            "card_expiration_date" => "0922",
            "card_holder_name" => "John Doe",
            "payment_method" => "credit_card",
            "customer" => [
                "external_id" => "1",
                "name" => "John Doe",
                "type" => "individual",
                "country" => "br",
                "documents" => [[
                    "type" => "cpf",
                    "number" => "00000000000"
                ]],
                "phone_numbers" => ["+551199999999"],
                "email" => "aardvark.silva@pagar.me"
            ],
            "billing" => [
                "name" => "John Doe",
                "address" => [
                    "country" => "br",
                    "street" => "Avenida Brigadeiro Faria Lima",
                    "street_number" => "1811",
                    "state" => "sp",
                    "city" => "Sao Paulo",
                    "neighborhood" => "Jardim Paulistano",
                    "zipcode" => "01451001"
                ]
            ],
            "items" => [
                [
                    "id" => "r123",
                    "title" => "Red pill",
                    "unit_price" => 10000,
                    "quantity" => 1,
                    "tangible" => true
                ],
                [
                    "id" => "b123",
                    "title" => "Blue pill",
                    "unit_price" => 10000,
                    "quantity" => 1,
                    "tangible" => true
                ]
            ]
        ]);

        $requestMethod = $container[0]['request']->getMethod();

        $this->assertEquals('POST', $requestMethod);
        $this->assertEquals($response->getArrayCopy(), json_decode(TransactionMock::mock(), true));
    }

    public function testTransactionList()
    {
        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(200, [], TransactionListMock::mock())
        ]);

        $handler = HandlerStack::create($mock);
        $handler->push($history);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->transactions()->get();

        $requestMethod = $container[0]['request']->getMethod();

        $this->assertEquals('GET', $requestMethod);
        $this->assertEquals($response->getArrayCopy(), json_decode(TransactionListMock::mock(), true));
    }

    public function testTransactionFind()
    {
        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(200, [], TransactionMock::mock())
        ]);

        $handler = HandlerStack::create($mock);

        $handler->push($history);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->transactions()->find(['id' => 1]);

        $request = $container[0]['request'];
        $requestMethod = $request->getMethod();
        $requestUri = $request->getUri()->getPath();

        $this->assertEquals('GET', $requestMethod);
        $this->assertEquals('/1/transactions/1', $requestUri);
        $this->assertEquals($response->getArrayCopy(), json_decode(TransactionMock::mock(), true));
    }

    public function testTransactionCapture()
    {
        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(200, [], TransactionMock::mock())
        ]);

        $handler = HandlerStack::create($mock);
        $handler->push($history);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->transactions()->capture(['id' => 1, 'amount' => '100']);

        $request = $container[0]['request'];
        $requestUri = $request->getUri()->getPath();
        $requestMethod = $request->getMethod();

        $this->assertEquals('/1/transactions/1/capture', $requestUri);
        $this->assertEquals('POST', $requestMethod);
        $this->assertEquals($response->getArrayCopy(), json_decode(TransactionMock::mock(), true));
    }
}
