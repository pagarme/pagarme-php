<?php

namespace PagarMe\Test;

use PagarMe\Client;
use PagarMe\Exceptions\PagarMeException;
use PagarMe\Endpoints\EndpointInterface;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

final class ClientTest extends TestCase
{
    public function testSuccessfulResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"status":"Ok!"}')
        ]);
        $handler = HandlerStack::create($mock);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->request(EndpointInterface::POST, 'transactions');

        $this->assertEquals($response->status, "Ok!");
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
            $response = $client->request(EndpointInterface::POST, 'transactions');
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

        $response = $client->request(EndpointInterface::POST, 'transactions');
    }
}
