<?php

namespace PagarMe\Sdk\Card\Request;

use PagarMe\Sdk\RequestInterface;

class CardCreateFromHash implements RequestInterface
{
    /**
     * @var string
     */
    private $cardHash;

    /**
     * @param string $cardHash
     */
    public function __construct($cardHash)
    {
        $this->cardHash = $cardHash;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [
            'card_hash' => $this->cardHash
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'cards';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_POST;
    }
}
