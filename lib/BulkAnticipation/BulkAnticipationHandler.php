<?php

namespace PagarMe\Sdk\BulkAnticipation;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Recipient\Recipient;
use PagarMe\Sdk\BulkAnticipation\Request\BulkAnticipationCreate;

class BulkAnticipationHandler extends AbstractHandler
{
    /**
    * @param  Recipient $recipient
    * @param  DateTime $paymentDate
    * @param  string $timeframe
    * @param  int $requestedAmount
    * @param  boolean $building
    */
    public function create(
        Recipient $recipient,
        \DateTime $paymentDate,
        $timeframe,
        $requestedAmount,
        $building
    ) {
        $request = new BulkAnticipationCreate(
            $recipient,
            $paymentDate,
            $timeframe,
            $requestedAmount,
            $building
        );

        $response = $this->client->send($request);
        $response->dateCreated = new \DateTime($response->dateCreated);
        $response->dateUpdated = new \DateTime($response->dateUpdated);
        $response->paymentDate = new \DateTime($response->paymentDate);

        return new BulkAnticipation(get_object_vars($response));
    }
}
