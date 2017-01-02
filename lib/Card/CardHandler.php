<?php

namespace PagarMe\Sdk\Card;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Client;
use PagarMe\Sdk\Card\Card;
use PagarMe\Sdk\Card\Request\CardCreate;
use PagarMe\Sdk\Card\Request\CardGet;

class CardHandler extends AbstractHandler
{
    /**
     * @param int $cardNumber
     * @param string $holderName
     * @param string $cardExpirationDate
     * @return Card
     */
    public function create($cardNumber, $holderName, $cardExpirationDate)
    {
        $request = new CardCreate(
            $cardNumber,
            $holderName,
            $cardExpirationDate
        );

        $response = $this->client->send($request);

        return $this->buildCard($response);
    }

    /**
     * @param int $cardId
     * @return Card
     */
    public function get($cardId)
    {
        $request = new CardGet(
            $cardId
        );

        $response = $this->client->send($request);

        return $this->buildCard($response);
    }

    /**
     * @param $cardData
     * @return Card
     */
    private function buildCard($cardData)
    {
        $cardData->date_created = new \DateTime($cardData->date_created);
        $cardData->date_updated = new \DateTime($cardData->date_updated);

        return new Card($cardData);
    }
}
