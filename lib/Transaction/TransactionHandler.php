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

    /**
     * @param int $amount
     * @param PagarMe\Sdk\Card\Card $card
     * @param PagarMe\Sdk\Customer\Customer $customer
     * @param int $installments
     * @param boolean $capture
     * @param string $postBackUrl
     * @param array $metaData
     * @param array $extraAttributes
     * @return CreditCardTransaction
     */
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

    /**
     * @param int $amount
     * @param PagarMe\Sdk\Customer\Customer $customer
     * @param string $postBackUrl
     * @param array $extraAttributes
     * @return BoletoTransaction
     */
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

    /**
     * @param int $transactionId
     * @return BoletoTransaction | CreditCardTransaction
     */
    public function get($transactionId)
    {
        $request = new TransactionGet($transactionId);

        $result = $this->client->send($request);

        return $this->buildTransaction($result);
    }

    /**
     * @param int $page
     * @param int $count
     * @return array
     */
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

    /**
     * @param CreditCardTransaction $transaction
     * @param int $amount
     * @return CreditCardTransaction
     */
    public function capture(CreditCardTransaction $transaction, $amount = null)
    {
        $request = new TransactionCapture($transaction->getId(), $amount);
        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    /**
     * @param CreditCardTransaction $transaction
     * @param int $amount
     * @return CreditCardTransaction
     */
    public function creditCardRefund(CreditCardTransaction $transaction, $amount = null)
    {
        $request = new CreditCardTransactionRefund($transaction, $amount);
        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    /**
     * @param BoletoTransaction $transaction
     * @param PagarMe\Sdk\BankAccount\BankAccount $bankAccount
     * @return BoletoTransaction
     */
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
