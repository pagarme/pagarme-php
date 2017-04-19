<?php

namespace PagarMe\SdkTest\Card\Request;

use PagarMe\Sdk\Card\Request\CardCreateFromHash;
use PagarMe\Sdk\RequestInterface;

class CardCreateFromHashTest extends \PHPUnit_Framework_TestCase
{
    const PATH          = 'cards';
    const CARD_HASH     = 'test_transaction_e8Ij0oYalvjTEO17IHqKxNQcigKrYj';

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $cardCreate = new CardCreateFromHash(self::CARD_HASH);

        $this->assertEquals(['card_hash' => self::CARD_HASH], $cardCreate->getPayload());
    }

    /**
     * @test
     */
    public function mustPathBeCorrect()
    {
        $cardCreate = new CardCreateFromHash(self::CARD_HASH);

        $this->assertEquals(self::PATH, $cardCreate->getPath());
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $cardCreate = new CardCreateFromHash(self::CARD_HASH);

        $this->assertEquals(RequestInterface::HTTP_POST, $cardCreate->getMethod());
    }
}
