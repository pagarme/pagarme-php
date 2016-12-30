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
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\Card\Card;
use PagarMe\Sdk\Customer\Customer;
use PagarMe\Sdk\Recipient\Recipient;
use PagarMe\Sdk\Event\Event;

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
        $metadata = null,
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
                'metadata'     => $metadata
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
        $metadata = null,
        $extraAttributes = []
    ) {
        $transactionData = array_merge(
            [
                'amount'      => $amount,
                'customer'    => $customer,
                'postBackUrl' => $postBackUrl,
                'metadata'    => $metadata
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
}
