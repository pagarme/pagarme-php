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
                new Response(200, [], self::jsonMock('RecipientListMock')),
                new Response(200, [], '[]')
            ]),
            'balance' => new MockHandler([
                new Response(200, [], self::jsonMock('BalanceMock'))
            ]),
            'balanceOperation' => new MockHandler([
                new Response(200, [], self::jsonMock('BalanceOperationMock'))
            ]),
            'balanceOperationList' => new MockHandler([
                new Response(200, [], self::jsonMock('BalanceOperationListMock')),
                new Response(200, [], '[]')
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
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            '/1/recipients',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('RecipientMock')),
            $response
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
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            '/1/recipients',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('RecipientListMock')),
            $response
        );

        $response = $client->recipients()->getList([
            'bank_account_id' => 123,
            'transfer_enabled' => true,
            'name' => 'RECEBEDOR TESTE'
        ]);

        $query = self::getQueryString($requestsContainer[1]);

        $this->assertContains('bank_account_id=123', $query);
        $this->assertContains('transfer_enabled=1', $query);
        $this->assertContains('name=RECEBEDOR%20TESTE', $query);

        $this->assertEquals(
            json_decode('[]'),
            $response
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
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            '/1/recipients/1',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('RecipientMock')),
            $response
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
            'bank_account_id' => 123
        ]);

        $requestBody = self::getBody($requestsContainer[0]);

        $this->assertEquals(
            Recipients::PUT,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            '/1/recipients/1',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('RecipientMock')),
            $response
        );
        $this->assertContains(
            '"bank_account_id":123',
            $requestBody
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
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            '/1/recipients/re_abc1234abc1234abc1234abc1/balance',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BalanceMock')),
            $response
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
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            '/1/recipients/re_abc1234abc1234abc1234abc1/balance/operations',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BalanceOperationListMock')),
            $response
        );

        $response = $client->recipients()->listBalanceOperation([
            'recipient_id' => 're_abc1234abc1234abc1234abc1',
            'count' => 5,
            'page' => 1
        ]);

        $query = self::getQueryString($requestsContainer[1]);

        $this->assertContains('count=5', $query);
        $this->assertContains('page=1', $query);

        $this->assertEquals(
            json_decode('[]'),
            $response
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
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            '/1/recipients/re_abc1234abc1234abc1234abc1/balance/operations/1',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BalanceOperationMock')),
            $response
        );
    }
}
