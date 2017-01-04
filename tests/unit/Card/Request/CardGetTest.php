<?php

namespace PagarMe\SdkTest\Card\Request;

use PagarMe\Sdk\Card\Request\CardGet;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    const PATH    = 'cards/card_ci6y37h16wrxsmzyi';
    const METHOD  = 'GET';
    const CARD_ID = 'card_ci6y37h16wrxsmzyi';

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $cardGet = new CardGet(self::CARD_ID);

        $this->assertEquals([], $cardGet->getPayload());
    }

    /**
     * @test
     */
    public function mustPathBeCorrect()
    {
        $cardGet = new CardGet(self::CARD_ID);

        $this->assertEquals(self::PATH, $cardGet->getPath());
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $cardGet = new CardGet(self::CARD_ID);

        $this->assertEquals(self::METHOD, $cardGet->getMethod());
    }
}
