<?php

namespace PagarMe\Sdk\Postback;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Transaction\AbstractTransaction;
use PagarMe\Sdk\Postback\Request\PostbackList;

class PostbackHandler extends AbstractHandler
{
    use \PagarMe\Sdk\Transaction\TransactionBuilder;
    /**
     * @param AbstractTransaction $transaction
     * @return array
     */
    public function getList(AbstractTransaction $transaction)
    {
        $request = new PostbackList($transaction);

        $response = $this->client->send($request);

        $postbacks = [];

        foreach ($response as $postbackData) {
            $postbacks[] = $this->buildPostback($response);
        }

        return $postbacks;
    }

    private function buildPostback($postbacksData)
    {
        $postbackData       = $postbacksData[0];
        $postbackDeliveries = [];

        foreach ($postbackData->deliveries as $postbackDeliveryData) {
            $postbackDeliveries[] =$this->buildPostbackDelivery(
                $postbackDeliveryData
            );
        }

        $postbackData->date_created = new \DateTime(
            $postbackData->date_created
        );
        $postbackData->date_updated = new \DateTime(
            $postbackData->date_updated
        );
        $postbackData->deliveries = $postbackDeliveries;

        $postbackData->payload = $this->buildPayload(
            $postbackData->payload
        );

        return new Postback(get_object_vars($postbackData));
    }

    private function buildPostbackDelivery($postbackDeliveryData)
    {
        $postbackDeliveryData->date_created = new \DateTime(
            $postbackDeliveryData->date_created
        );
        $postbackDeliveryData->date_updated = new \DateTime(
            $postbackDeliveryData->date_updated
        );

        return new Delivery($postbackDeliveryData);
    }

    private function buildPayload($payloadData)
    {
        parse_str($payloadData, $payload);

        $payload['transaction'] = $this->buildTransaction(
            (object) $payload['transaction']
        );

        return new Payload($payload);
    }
}
