<?php

namespace PagarMe\Sdk\Card\Request;

use PagarMe\Sdk\RequestInterface;

class CardCreate implements RequestInterface
{
    /**
     * @var int
     */
    private $cardNumber;

    /**
     * @var string
     */
    private $holderName;

    /**
     * @var int
     */
    private $cardExpirationDate;

    /**
     * @var int
     */
    private $cardCvv;

    /**
     * @param int $cardNumber
     * @param string $holderName
     * @param int $cardExpirationDate
     * @param int $cardCvv
     */
    public function __construct($cardNumber, $holderName, $cardExpirationDate, $cardCvv = null)
    {
        $this->cardNumber         = $cardNumber;
        $this->holderName         = $holderName;
        $this->cardExpirationDate = $cardExpirationDate;
        $this->cardCvv            = $cardCvv;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        $cardData = [
            'card_number'          => $this->cardNumber,
            'holder_name'          => $this->holderName,
            'card_expiration_date' => $this->cardExpirationDate
        ];

        if (!is_null($this->cardCvv)) {
            $cardData['card_cvv'] = $this->cardCvv;
        }

        return $cardData;
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
