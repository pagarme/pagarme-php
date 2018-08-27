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
        return [
            [
                new MockHandler([
                    new Response(200, [], self::jsonMock('BankAccountMock'))
                ])
            ]
        ];
    }

    /**
     * @dataProvider bankAccountProvider
     */
    public function testBankAccountCreate($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->bankAccounts()->create([
            'bank_code' => '341',
            'agencia' => '0932',
            'agencia_dv' => '5',
            'conta' => '58054',
            'conta_dv' => '1',
            'document_number' => '26268738888',
            'legal_name' => 'API BANK ACCOUNTAPI BANK ACCOUNTAPI BANK ACCOUNTAPI 
            BANK ACCOUNTAPI BANK ACCOUNT'
        ]);

        $this->assertEquals('/1/bank_accounts', self::getRequestUri($requestsContainer));
        $this->assertEquals(BankAccounts::POST, self::getRequestMethod($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('BankAccountMock'), true));
    }

    public function testBankAccountGetList()
    {
        $requestsContainer = [];

        $mock = new MockHandler([
            new Response(200, [], self::jsonMock('BankAccountListMock'))
        ]);

        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->bankAccounts()->getList();

        $this->assertEquals('/1/bank_accounts', self::getRequestUri($requestsContainer));
        $this->assertEquals(BankAccounts::GET, self::getRequestMethod($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('BankAccountListMock'), true));
    }

    /**
     * @dataProvider bankAccountProvider
     */
    public function testBankAccountGet($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock);

        $response = $client->bankAccounts()->get(['id' => 1]);

        $this->assertEquals('/1/bank_accounts/1', self::getRequestUri($requestsContainer));
        $this->assertEquals(BankAccounts::GET, self::getRequestMethod($requestsContainer));
        $this->assertEquals($response->getArrayCopy(), json_decode(self::jsonMock('BankAccountMock'), true));
    }
}
