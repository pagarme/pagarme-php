<?php

namespace PagarMe\SdkTest\Transfer\Request;

use PagarMe\Sdk\Transfer\Request\TransferList;

class TransferListTest extends \PHPUnit_Framework_TestCase
{
    const METHOD       = 'GET';
    const PATH         = 'transfers';

    public function paginationData()
    {
        return [
            [1, 15],
            [2, null],
            [null, 5],
            [null, null],
        ];
    }

    /**
     * @dataProvider paginationData
     * @test
     */
    public function mustPayloadBeCorrect($page, $count)
    {

        $transferList = new TransferList($page, $count);

        $this->assertEquals(
            [
                'page'  => $page,
                'count' => $count
            ],
            $transferList->getPayload()
        );

        $this->assertEquals(self::METHOD, $transferList->getMethod());

        $this->assertEquals(self::PATH, $transferList->getPath());
    }
}
