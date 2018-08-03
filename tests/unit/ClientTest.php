<?php

namespace PagarMe\Test;

use PagarMe\Client;
use PagarMe\PagarMeException;
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
     * @expectedException \PagarMe\PagarMeException
     */
    public function testFailedResponse()
    {
        $mock = new MockHandler([
            new Response(401, [], 'Unauthorized')
        ]);
        $handler = HandlerStack::create($mock);

        $client = new Client('apiKey', ['handler' => $handler]);

        $response = $client->request(EndpointInterface::POST, 'transactions');
    }
}
