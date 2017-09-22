<?php

namespace PagarMe\SdkTest\Transaction\Request;

use PHPUnit_Framework_TestCase as TestCase;
use PagarMe\Sdk\Transaction\Request\TransactionFind;

class TransactionFindTest extends TestCase
{
    const PATH = 'transactions';

    public function filtersProvider()
    {
        return [
            [[], null, null],
            [[], 2, null],
            [[], 1, 5],
            [['id' => 123456], 4, 10],
            [['reference_key' => 'abcd123456'], 7, 20],
            [['amount' => 100, 'page' => 2, 'count' => 3], 7, 20],
        ];
    }

    /**
     * @dataProvider filtersProvider
     */
    public function testIfThePayloadIsCorrect($filters, $page, $limit)
    {
        $transactionFind = new TransactionFind($filters, $page, $limit);
        $expectedPayload = array_merge($filters, [
            'page' => $page,
            'count' => $limit,
        ]);

        $this->assertEquals($expectedPayload, $transactionFind->getPayload());
    }

    /**
     * @dataProvider filtersProvider
     */
    public function testIfThePathIsCorrect($filters, $page, $limit)
    {
        $transactionFind = new TransactionFind($filters, $page, $limit);
        $this->assertEquals(self::PATH, $transactionFind->getPath());
    }

    /**
     * @dataProvider filtersProvider
     */
    public function testIfTheMethodIsCorrect($filters, $page, $limit)
    {
        $transactionFind = new TransactionFind($filters, $page, $limit);
        $this->assertEquals('GET', $transactionFind->getMethod());
    }
}
