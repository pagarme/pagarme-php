<?php

namespace PagarMe\SdkTest\Transaction\Request;

use PagarMe\Sdk\RequestInterface;
use PagarMe\Sdk\Transaction\Request\TransactionList;

class TransactionListTest extends \PHPUnit_Framework_TestCase
{
    const PATH = 'transactions';

    public function paginationProvider()
    {
        return [
            [null, null, []],
            [null, null, ['status' => 'waiting_payment']],
            [2, null, ['status' => 'waiting_payment']],
            [1, 5, []],
            [4, 10, ['card_holder_name' => 'foo']],
            [7, 20, []],
        ];
    }

    /**
     * @dataProvider paginationProvider
     * @test
     */
    public function mustPayloadBeCorrect($page, $items, array $extraParameters = [])
    {
        $transactionCreate = new TransactionList($page, $items, $extraParameters);

        $this->assertEquals(array_merge([
            'page'  => $page,
            'count' => $items
        ], $extraParameters),
            $transactionCreate->getPayload()
        );
    }

    /**
     * @dataProvider paginationProvider
     * @test
     */
    public function mustPathBeCorrect($page, $items)
    {
        $transactionCreate = new TransactionList($page, $items);

        $this->assertEquals(self::PATH, $transactionCreate->getPath());
    }

    /**
     * @dataProvider paginationProvider
     * @test
     */
    public function mustMethodBeCorrect($page, $items)
    {
        $transactionCreate = new TransactionList($page, $items);

        $this->assertEquals(RequestInterface::HTTP_GET, $transactionCreate->getMethod());
    }
}
