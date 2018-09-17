<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\BankAccounts;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

final class BankAccountTest extends PagarMeTestCase
{
    public function bankAccountProvider()
    {
        return [[[
            'account' => new MockHandler([
                new Response(200, [], self::jsonMock('BankAccountMock'))
            ]),
            'list' => new MockHandler([
                new Response(200, [], self::jsonMock('BankAccountListMock')),
                new Response(200, [], '[]'),
            ]),
        ]]];
    }

    /**
     * @dataProvider bankAccountProvider
     */
    public function testBankAccountCreate($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['account']);

        $response = $client->bankAccounts()->create([
            'bank_code' => '341',
            'agencia' => '0932',
            'agencia_dv' => '5',
            'conta' => '58054',
            'conta_dv' => '1',
            'document_number' => '26268738888',
            'legal_name' => 'API BANK ACCOUNT'
        ]);

        $this->assertEquals(
            '/1/bank_accounts',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            BankAccounts::POST,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BankAccountMock')),
            $response
        );
    }

    /**
     * @dataProvider bankAccountProvider
     */
    public function testBankAccountGetList($mock)
    {
        $requestsContainer = [];

        $client = self::buildClient($requestsContainer, $mock['list']);

        $response = $client->bankAccounts()->getList();

        $this->assertEquals(
            '/1/bank_accounts',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            BankAccounts::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BankAccountListMock')),
            $response
        );

        $response = $client->bankAccounts()->getList([
            'id' => 123,
            'bank_code' => '456',
            'agencia' => '7890'
        ]);

        $query = self::getQueryString($requestsContainer[1]);

        $this->assertContains('id=123', $query);
        $this->assertContains('bank_code=456', $query);
        $this->assertContains('agencia=7890', $query);
        $this->assertEquals(
            json_decode('[]'),
            $response
        );
    }

    /**
     * @dataProvider bankAccountProvider
     */
    public function testBankAccountGet($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['account']);

        $response = $client->bankAccounts()->get(['id' => 1]);

        $this->assertEquals(
            '/1/bank_accounts/1',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            BankAccounts::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BankAccountMock')),
            $response
        );
    }
}
