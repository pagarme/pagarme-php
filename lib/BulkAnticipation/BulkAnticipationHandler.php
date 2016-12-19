<?php

namespace PagarMe\Sdk\BulkAnticipation;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Recipient\Recipient;
use PagarMe\Sdk\BulkAnticipation\Request\BulkAnticipationCreate;
use PagarMe\Sdk\BulkAnticipation\Request\BulkAnticipationLimits;

class BulkAnticipationHandler extends AbstractHandler
{
    /**
    * @param  Recipient $recipient
    * @param  DateTime $paymentDate
    * @param  string $timeframe
    * @param  int $requestedAmount
    * @param  boolean $building
    * @return BulkAnticipation
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

    /**
    * @param  Recipient $recipient
    * @param  DateTime $paymentDate
    * @param  string $timeframe
    * @return  array
    */
    public function limits($recipient, $paymentDate, $timeframe)
    {
        $request = new BulkAnticipationLimits(
            $recipient,
            $paymentDate,
            $timeframe
        );

        return $this->client->send($request);
    }
}
