<?php

namespace PagarMe\Sdk\Transaction;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Client;
use PagarMe\Sdk\Transaction\Request\CreditCardTransactionCreate;
use PagarMe\Sdk\Transaction\Request\BoletoTransactionCreate;
use PagarMe\Sdk\Transaction\Request\TransactionGet;
use PagarMe\Sdk\Transaction\Request\TransactionList;
use PagarMe\Sdk\Transaction\Request\TransactionCapture;
use PagarMe\Sdk\Transaction\Request\TransactionEvents;
use PagarMe\Sdk\Transaction\Request\CreditCardTransactionRefund;
use PagarMe\Sdk\Transaction\Request\BoletoTransactionRefund;
use PagarMe\Sdk\Transaction\Request\TransactionPay;
use PagarMe\Sdk\Transaction\Request\PostbackTransactionList;
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\Card\Card;
use PagarMe\Sdk\Customer\Customer;
use PagarMe\Sdk\Recipient\Recipient;
use PagarMe\Sdk\Event\Event;
use PagarMe\Sdk\Postback\Postback;
use PagarMe\Sdk\Postback\Delivery;
use PagarMe\Sdk\Postback\Payload;

class TransactionHandler extends AbstractHandler
{
    use TransactionBuilder;

    public function creditCardTransaction(
        $amount,
        Card $card,
        Customer $customer,
        $installments = 1,
        $capture = true,
        $postBackUrl = null,
        $metaData = null,
        $extraAttributes = []
    ) {
        $transactionData = array_merge(
            [
                'amount'       => $amount,
                'card'         => $card,
                'customer'     => $customer,
                'installments' => $installments,
                'capture'      => $capture,
                'postbackUrl'  => $postBackUrl,
                'metaData'     => $metaData
            ],
            $extraAttributes
        );

        $transaction = new CreditCardTransaction($transactionData);
        $request = new CreditCardTransactionCreate($transaction);
        $result = $this->client->send($request);

        return $this->buildTransaction($result);
    }

    public function boletoTransaction(
        $amount,
        Customer $customer,
        $postBackUrl,
        $extraAttributes = []
    ) {
        $transactionData = array_merge(
            [
                'amount'      => $amount,
                'customer'    => $customer,
                'postBackUrl' => $postBackUrl
            ],
            $extraAttributes
        );

        $transaction = new BoletoTransaction($transactionData);

        $request = new BoletoTransactionCreate($transaction);

        $result = $this->client->send($request);

        return $this->buildTransaction($result);
    }

    public function get($transactionId)
    {
        $request = new TransactionGet($transactionId);

        $result = $this->client->send($request);

        return $this->buildTransaction($result);
    }

    public function getList($page = 1, $count = 10)
    {
        $request = new TransactionList($page, $count);
        $response = $this->client->send($request);

        $transactions = [];
        foreach ($response as $transactionData) {
            $transactions[] = $this->buildTransaction($transactionData);
        }

        return $transactions;
    }

    public function capture(CreditCardTransaction $transaction, $amount = null)
    {
        $request = new TransactionCapture($transaction->getId(), $amount);
        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    public function creditCardRefund(CreditCardTransaction $transaction, $amount = null)
    {
        $request = new CreditCardTransactionRefund($transaction, $amount);
        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    public function boletoRefund(
        BoletoTransaction $transaction,
        BankAccount $bankAccount,
        $amount = null
    ) {
        $request = new BoletoTransactionRefund($transaction, $bankAccount, $amount);
        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    /**
     * @param BoletoTransaction $transaction
     * @return BoletoTransaction
     */
    public function payTransaction(BoletoTransaction $transaction)
    {
        $request = new TransactionPay($transaction);

        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    /**
     * @param AbstractTransaction $transaction
     * @return array
     */
    public function events(AbstractTransaction $transaction)
    {
        $request = new TransactionEvents($transaction);

        $response = $this->client->send($request);

        $events = [];

        foreach ($response as $eventData) {
            $eventData->date_created = new \DateTime($eventData->date_created);
            $eventData->date_updated = new \DateTime($eventData->date_updated);
            $events[] = new Event($eventData);
        }

        return $events;
    }

    /**
     * @param AbstractTransaction $transaction
     * @return array
     */
    public function postbackList(AbstractTransaction $transaction)
    {
        $request = new PostbackTransactionList($transaction);

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
