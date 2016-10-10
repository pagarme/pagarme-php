<?php

namespace PagarMe\Sdk\Card\Request;

use PagarMe\Sdk\Request;

class CardCreate implements Request
{
    /**
     * @var int | Número no cartão do portador
     */
    private $cardNumber;

    /**
     * @var int | Nome no cartão do portador
     */
    private $holderName;

    /**
     * @var int | Data de expiração do cartão
     */
    private $cardExpirationDate;

    /**
    * @param int $cardNumber
    * @param int $holderName
    * @param int $cardExpirationDate
    */
    public function __construct($cardNumber, $holderName, $cardExpirationDate)
    {
        $this->cardNumber         = $cardNumber;
        $this->holderName         = $holderName;
        $this->cardExpirationDate = $cardExpirationDate;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [
            'card_number'          => $this->cardNumber,
            'holder_name'          => $this->holderName,
            'card_expiration_date' => $this->cardExpirationDate
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
        return 'POST';
    }

    /**
     * @return string
     */
    public function getAuthenticationMethod()
    {
        return self::API_KEY;
    }
}
