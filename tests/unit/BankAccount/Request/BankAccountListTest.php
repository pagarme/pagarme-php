<?php

namespace PagarMe\SdkTest\BankAccount\Request;

use PagarMe\Sdk\BankAccount\Request\BankAccountList;

class BankAccountListTest extends \PHPUnit_Framework_TestCase
{
    const PATH            = 'bank_accounts';
    const METHOD          = 'GET';

    public function bankAccountListParams()
    {
        return [
            [null, null],
            [1, null],
            [null, 2],
            [3, 4],
        ];
    }

    /**
     * @dataProvider bankAccountListParams
     * @test
     */
    public function mustContentBeCorrect($page, $count)
    {
        $request = new BankAccountList(
            $page,
            $count
        );

        $this->assertEquals(self::METHOD, $request->getMethod());
        $this->assertEquals(self::PATH, $request->getPath());
        $this->assertEquals(
            [
                'page'  => $page,
                'count' => $count
            ],
            $request->getPayload()
        );
    }
}
