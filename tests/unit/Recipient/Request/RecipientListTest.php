<?php

namespace PagarMe\SdkTests\Recipient;

use PagarMe\Sdk\Recipient\Request\RecipientList;

class RecipientListTest extends \PHPUnit_Framework_TestCase
{
    const PATH            = 'recipients';
    const METHOD          = 'GET';

    public function recipientListProvider()
    {
        return [
            [null, null],
            [2, 15],
            [1, 50],
            [3, null],
            [null, 15]
        ];
    }

    /**
     * @dataProvider recipientListProvider
     * @test
     */
    public function mustPathBeCorrect($page, $count)
    {
        $recipientList = new RecipientList($page, $count);

        $this->assertEquals(self::PATH, $recipientList->getPath());
    }

    /**
     * @dataProvider recipientListProvider
     * @test
     */
    public function mustMethodBeCorrect($page, $count)
    {
        $recipientList = new RecipientList($page, $count);

        $this->assertEquals(self::METHOD, $recipientList->getMethod());
    }

    /**
     * @dataProvider recipientListProvider
     * @test
     */
    public function mustPayloadBeCorrect($page, $count)
    {
        $recipientList = new RecipientList($page, $count);

        $this->assertEquals(
            [
                'count' => $count,
                'page'  => $page
            ],
            $recipientList->getPayload()
        );
    }
}
