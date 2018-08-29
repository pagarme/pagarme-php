<?php

namespace PagarMe\Endpoints\Test;

use PagarMe\Client;
use PagarMe\Endpoints\BulkAnticipations;
use PagarMe\Test\Endpoints\PagarMeTestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class BulkAnticipationsTest extends PagarMeTestCase
{
    public function mockProvider()
    {
        return [[[
            'anticipation' => new MockHandler([
                new Response(200, [], self::jsonMock('BulkAnticipationMock'))
            ]),
            'limits' => new MockHandler([
                new Response(200, [], self::jsonMock('BulkAnticipationLimitsMock'))
            ]),
            'delete' => new MockHandler([
                new Response(200, [], '[]')
            ]),
            'list' => new MockHandler([
                new Response(200, [], self::jsonMock('BulkAnticipationListMock'))
            ]),
        ]]];
    }

    /**
     * @dataProvider mockProvider
     */
    public function testBulkAnticipationCreate($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['anticipation']);

        $response = $client->bulkAnticipations()->create([
            'recipient_id' => 're_abc1234abc1234abc1234abc1',
            'payment_date' => '1234567890000',
            'timeframe' => 'start',
            'requested_amount' => '1000',
            'build' => true
        ]);

        $this->assertEquals(
            BulkAnticipations::POST,
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            '/1/recipients/re_abc1234abc1234abc1234abc1/bulk_anticipations',
            self::getRequestUri($container)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BulkAnticipationMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testBulkAnticipationGetLimits($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['limits']);

        $response = $client->bulkAnticipations()->getLimits([
            'recipient_id' => 're_abc1234abc1234abc1234abc1',
            'payment_date' => '1234567890000',
            'timeframe' => 'start'
        ]);

        $this->assertEquals(
            BulkAnticipations::GET,
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            '/1/recipients/re_abc1234abc1234abc1234abc1/bulk_anticipations/limits',
            self::getRequestUri($container)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BulkAnticipationLimitsMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testBulkAnticipationConfirm($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['anticipation']);

        $response = $client->bulkAnticipations()->confirm([
            'recipient_id' => 're_abc1234abc1234abc1234abc1',
            'bulk_anticipation_id' => 'ba_abc1234abc1234abc1234abc1'
        ]);

        $this->assertEquals(
            BulkAnticipations::POST,
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            '/1/recipients/re_abc1234abc1234abc1234abc1/bulk_anticipations/ba_abc1234abc1234abc1234abc1/confirm',
            self::getRequestUri($container)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BulkAnticipationMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testBulkAnticipationCancel($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['anticipation']);

        $response = $client->bulkAnticipations()->cancel([
            'recipient_id' => 're_abc1234abc1234abc1234abc1',
            'bulk_anticipation_id' => 'ba_abc1234abc1234abc1234abc1'
        ]);

        $this->assertEquals(
            BulkAnticipations::POST,
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            '/1/recipients/re_abc1234abc1234abc1234abc1/bulk_anticipations/ba_abc1234abc1234abc1234abc1/cancel',
            self::getRequestUri($container)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BulkAnticipationMock'), true),
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testBulkAnticipationDelete($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['delete']);

        $response = $client->bulkAnticipations()->delete([
            'recipient_id' => 're_abc1234abc1234abc1234abc1',
            'bulk_anticipation_id' => 'ba_abc1234abc1234abc1234abc1'
        ]);

        $this->assertEquals(
            BulkAnticipations::DELETE,
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            '/1/recipients/re_abc1234abc1234abc1234abc1/bulk_anticipations/ba_abc1234abc1234abc1234abc1',
            self::getRequestUri($container)
        );
        $this->assertEquals(
            [],
            $response->getArrayCopy()
        );
    }

    /**
     * @dataProvider mockProvider
     */
    public function testBulkAnticipationList($mock)
    {
        $container = [];
        $client = self::buildClient($container, $mock['list']);

        $response = $client->bulkAnticipations()->getList([
            'recipient_id' => 're_abc1234abc1234abc1234abc1'
        ]);

        $this->assertEquals(
            BulkAnticipations::GET,
            self::getRequestMethod($container)
        );
        $this->assertEquals(
            '/1/recipients/re_abc1234abc1234abc1234abc1/bulk_anticipations',
            self::getRequestUri($container)
        );
        $this->assertEquals(
            json_decode(self::jsonMock('BulkAnticipationListMock'), true),
            $response->getArrayCopy()
        );
    }
}
