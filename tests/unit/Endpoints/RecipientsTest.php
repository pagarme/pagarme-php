<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Recipients;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

final class RecipientTest extends PagarMeTestCase
{
    public function mockProvider()
    {
        return [[[
            'recipient' => new MockHandler([
                new Response(200, [], self::jsonMock('RecipientMock'))
            ]),
            'recipientList' => new MockHandler([
                new Response(200, [], self::jsonMock('RecipientListMock'))
            ]),
            'balance' => new MockHandler([
                new Response(200, [], self::jsonMock('BalanceMock'))
            ]),
            'balanceOperation' => new MockHandler([
                new Response(200, [], self::jsonMock('BalanceOperationMock'))
            ]),
            'balanceOperationList' => new MockHandler([
                new Response(200, [], self::jsonMock('BalanceOperationListMock'))
            ]),
        ]]];
    }

    /**
     * @dataProvider mockProvider
     */
    public function testRecipientCreate($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['recipient']);

        $response = $client->recipients()->create([
            'transfer_interval' => 'weekly',
            'transfer_day' => 5,
            'transfer_enabled' => true,
            'automatic_anticipation_enabled' => true,
            'anticipatable_volume_percentage' => 85,
            'bank_account_id' => 4841
        ]);

        $this->assertEquals(
            Recipients::POST,
            self::getRequestMethod($requestsContainer)
        );
        $this->assertEquals(
            '/1/recipients',
            self::getRequestUri($requestsContainer)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('RecipientMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testRecipientList($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['recipientList']);

        $response = $client->recipients()->getList();

        $this->assertEquals(
            Recipients::GET,
            self::getRequestMethod($requestsContainer)
        );
        $this->assertEquals(
            '/1/recipients',
            self::getRequestUri($requestsContainer)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('RecipientListMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testRecipientGet($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['recipient']);

        $response = $client->recipients()->get(['id' => 1]);

        $this->assertEquals(
            Recipients::GET,
            self::getRequestMethod($requestsContainer)
        );
        $this->assertEquals(
            '/1/recipients/1',
            self::getRequestUri($requestsContainer)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('RecipientMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testRecipientUpdate($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['recipient']);

        $response = $client->recipients()->update([
            'id' => '1',
            'transfer_interval' => 'monthly',
            'transfer_day' => 5,
            'transfer_enabled' => true,
            'automatic_anticipation_enabled' => true,
            'anticipatable_volume_percentage' => 100,
            'bank_account_id' => 123
        ]);

        $this->assertEquals(
            Recipients::PUT,
            self::getRequestMethod($requestsContainer)
        );
        $this->assertEquals(
            '/1/recipients/1',
            self::getRequestUri($requestsContainer)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('RecipientMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testRecipientGetBalance($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['balance']);

        $response = $client->recipients()->getBalance([
            'recipient_id' => 're_abc1234abc1234abc1234abc1'
        ]);

        $this->assertEquals(
            Recipients::GET,
            self::getRequestMethod($requestsContainer)
        );
        $this->assertEquals(
            '/1/recipients/re_abc1234abc1234abc1234abc1/balance',
            self::getRequestUri($requestsContainer)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BalanceMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testRecipientListBalanceOperations($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['balanceOperationList']);

        $response = $client->recipients()->listBalanceOperation([
            'recipient_id' => 're_abc1234abc1234abc1234abc1'
        ]);

        $this->assertEquals(
            Recipients::GET,
            self::getRequestMethod($requestsContainer)
        );
        $this->assertEquals(
            '/1/recipients/re_abc1234abc1234abc1234abc1/balance/operations',
            self::getRequestUri($requestsContainer)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BalanceOperationListMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testRecipientGetBalanceOperation($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['balanceOperation']);

        $response = $client->recipients()->getBalanceOperation([
            'recipient_id' => 're_abc1234abc1234abc1234abc1',
            'balance_operation_id' => '1'
        ]);

        $this->assertEquals(
            Recipients::GET,
            self::getRequestMethod($requestsContainer)
        );
        $this->assertEquals(
            '/1/recipients/re_abc1234abc1234abc1234abc1/balance/operations/1',
            self::getRequestUri($requestsContainer)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BalanceOperationMock'), true),
            $response->getArrayCopy()
        );
    }
}
