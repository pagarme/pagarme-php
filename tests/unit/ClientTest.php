<?php

namespace PagarMe\Test;

use PagarMe\Client;
use PagarMe\Exceptions\PagarMeException;
use PagarMe\Endpoints\Endpoint;
use PagarMe\Endpoints\Transactions;
use PagarMe\Endpoints\Customers;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

final class ClientTest extends TestCase
{
    public function testSuccessfulResponse()
    {
        $container = [];
        $history = Middleware::history($container);
        $mock = new MockHandler([
            new Response(200, [], '{"status":"Ok!"}'),
        ]);
        $handler = HandlerStack::create($mock);
        $handler->push($history);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->request(Endpoint::POST, 'transactions');

        $this->assertEquals($response->status, "Ok!");
        $this->assertEquals(
            'api_key=apiKey',
            $container[0]['request']->getUri()->getQuery()
        );
    }

    /**
     * @expectedException \PagarMe\Exceptions\PagarMeException
     */
    public function testPagarMeFailedResponse()
    {
        $mock = new MockHandler([
            new Response(401, [], '{
                "errors": [{
                    "message": "api_key está faltando",
                    "parameter_name": "api_key",
                    "type": "invalid_parameter"
                }],
                "method": "get",
                "url": "/transactions"
            }')
        ]);

        $handler = HandlerStack::create($mock);

        $client = new Client('apiKey', ['handler' => $handler]);

        try {
            $response = $client->request(Endpoint::POST, 'transactions');
        } catch (\PagarMe\Exceptions\PagarMeException $exception) {
            $this->assertEquals('api_key está faltando', $exception->getMessage());
            $this->assertEquals('api_key', $exception->getParameterName());
            $this->assertEquals('invalid_parameter', $exception->getType());

            throw $exception;
        }
    }

    /**
     * @expectedException \GuzzleHttp\Exception\ServerException
     */
    public function testRequestFailedResponse()
    {
        $mock = new MockHandler([
            new Response(502, [], '<div>Bad Gateway</div>')
        ]);

        $handler = HandlerStack::create($mock);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->request(Endpoint::POST, 'transactions');
    }

    public function testDefaultUserAgent()
    {
        $client = new Client('apikey');

        $this->assertEquals(
            'PHP/5.6.37',
            $client->getUserAgent(),
            'The default user-agent must have php version'
        );
    }

    public function testBuildUserAgentWithCustomHeader()
    {
        $client = new Client(
            'apikey',
            ['headers' => ['User-Agent' => 'MyCustomIntegration/3.14.0']]
        );

        $this->assertEquals(
            'MyCustomIntegration/3.14.0 PHP/5.6.37',
            $client->getUserAgent()
        );
    }

    public function testTransactions()
    {
        $client = new Client('apiKey');

        $transactions = $client->transactions();

        $this->assertInstanceOf(Transactions::class, $transactions);
    }

    public function testCustomers()
    {
        $client = new Client('apiKey');

        $customers = $client->customers();

        $this->assertInstanceOf(Customers::class, $customers);
    }
}
