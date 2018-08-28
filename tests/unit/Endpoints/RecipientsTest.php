<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Recipients;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

final class RecipientTest extends PagarMeTestCase
{
    public function recipientProvider()
    {
        return [
            [
                new MockHandler([
                    new Response(200, [], self::jsonMock('RecipientMock'))
                ])
            ]
        ];
    }

    public function balanceProvider()
    {
        return [
            [
                new MockHandler([
                    new Response(200, [], self::jsonMock('BalanceMock'))
                ])
            ]
        ];
    }

    /**
     * @dataProvider recipientProvider
     */
    public function testRecipientCreate($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->recipients()->create([
            'transfer_interval' => 'weekly',
            'transfer_day' => 5,
            'transfer_enabled' => true,
            'automatic_anticipation_enabled' => true,
            'anticipatable_volume_percentage' => 85,
            'bank_account_id' => 4841
        ]);

        $this->assertEquals(Recipients::POST, self::getRequestMethod($requestsContainer));
        $this->assertEquals('/1/recipients', self::getRequestUri($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('RecipientMock'), true));
    }

    public function testRecipientList()
    {
        $mock = new MockHandler([
            new Response(200, [], self::jsonMock('RecipientListMock'))
        ]);

        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->recipients()->getList();

        $this->assertEquals(Recipients::GET, self::getRequestMethod($requestsContainer));
        $this->assertEquals('/1/recipients', self::getRequestUri($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('RecipientListMock'), true));
    }

    /**
     * @dataProvider recipientProvider
     */
    public function testRecipientFind($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->recipients()->get(['id' => 1]);

        $this->assertEquals(Recipients::GET, self::getRequestMethod($requestsContainer));
        $this->assertEquals('/1/recipients/1', self::getRequestUri($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('RecipientMock'), true));
    }

    /**
     * @dataProvider recipientProvider
     */
    public function testRecipientUpdate($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->recipients()->update([
            'id' => '1',
            'transfer_interval' => 'monthly',
            'transfer_day' => 5,
            'transfer_enabled' => true,
            'automatic_anticipation_enabled' => true,
            'anticipatable_volume_percentage' => 100,
            'bank_account_id' => 123
        ]);

        $this->assertEquals(Recipients::PUT, self::getRequestMethod($requestsContainer));
        $this->assertEquals('/1/recipients/1', self::getRequestUri($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('RecipientMock'), true));
    }

    /**
     * @dataProvider balanceProvider
     */
    public function testRecipientBalance($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->recipients()->getBalance(['id' => '1' ]);

        $this->assertEquals(Recipients::GET, self::getRequestMethod($requestsContainer));
        $this->assertEquals('/1/recipients/1/balance', self::getRequestUri($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('BalanceMock'), true));
    }

    public function testRecipientBalanceOperations()
    {
        $mock = new MockHandler([
            new Response(200, [], self::jsonMock('BalanceOperationListMock'))
        ]);

        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->recipients()->getBalanceOperationList(['id' => '1' ]);

        $this->assertEquals(Recipients::GET, self::getRequestMethod($requestsContainer));
        $this->assertEquals('/1/recipients/1/balance/operations', self::getRequestUri($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('BalanceOperationListMock'), true));
    }

    public function testRecipientBalanceOperation()
    {
        $mock = new MockHandler([
            new Response(200, [], self::jsonMock('BalanceOperationMock'))
        ]);

        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->recipients()->getBalanceOperation(['recipient_id' => '1', 'balance_operation_id' => '1' ]);

        $this->assertEquals(Recipients::GET, self::getRequestMethod($requestsContainer));
        $this->assertEquals('/1/recipients/1/balance/operations/1', self::getRequestUri($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('BalanceOperationMock'), true));
    }
}
