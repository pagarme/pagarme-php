<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\Plans;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

final class PlanTest extends PagarMeTestCase
{
    public function planProvider()
    {
        return [[[
            'plan' => new MockHandler([
                new Response(200, [], self::jsonMock('PlanMock'))
            ]),
            'planList' => new MockHandler([
                new Response(200, [], self::jsonMock('PlanListMock')),
                new Response(200, [], '[]')
            ])
        ]]];
    }

    /**
     * @dataProvider planProvider
     */
    public function testPlanCreate($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['plan']);

        $response = $client->plans()->create([
            'amount' => 15000,
            'days' => 30,
            'name' => 'The Pro Plan - Platinum  - Best Ever'
        ]);

        $this->assertEquals(
            '/1/plans',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Plans::POST,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PlanMock')),
            $response
        );
    }

    /**
     * @dataProvider planProvider
     */
    public function testPlanGetList($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['planList']);

        $response = $client->plans()->getList();

        $this->assertEquals(
            '/1/plans',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Plans::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PlanListMock')),
            $response
        );

        $response = $client->plans()->getList([
            'amount' => '3000',
            'days' => 30,
            'name' => 'Super Duper Plan'
        ]);

        $query = self::getQueryString($requestsContainer[1]);

        $this->assertContains('amount=3000', $query);
        $this->assertContains('days=30', $query);
        $this->assertContains('name=Super%20Duper%20Plan', $query);

        $this->assertEquals(
            json_decode('[]'),
            $response
        );
    }

    /**
     * @dataProvider planProvider
     */
    public function testPlanGet($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['plan']);

        $response = $client->plans()->get(['id' => 1]);

        $this->assertEquals(
            '/1/plans/1',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Plans::GET,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PlanMock')),
            $response
        );
    }

    /**
     * @dataProvider planProvider
     */
    public function testPlanUpdate($mock)
    {
        $requestsContainer = [];
        $client = self::buildClient($requestsContainer, $mock['plan']);

        $response = $client->plans()->update([
            'id' => 1,
            'name' => 'novo nome do plano',
        ]);

        $requestBody = self::getBody($requestsContainer[0]);

        $this->assertEquals(
            '/1/plans/1',
            self::getRequestUri($requestsContainer[0])
        );
        $this->assertEquals(
            Plans::PUT,
            self::getRequestMethod($requestsContainer[0])
        );
        $this->assertEquals(
            json_decode(self::jsonMock('PlanMock')),
            $response
        );
        $this->assertContains(
            '"name":"novo nome do plano"',
            $requestBody
        );
    }
}
