<?php

namespace PagarMe\Sdk\Transaction;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Client;
use PagarMe\Sdk\Transaction\Request\CreditCardTransactionCreate;
use PagarMe\Sdk\Transaction\Request\BoletoTransactionCreate;
use PagarMe\Sdk\Transaction\Request\TransactionGet;
use PagarMe\Sdk\Transaction\Request\TransactionList;
use PagarMe\Sdk\Transaction\Request\TransactionCapture;
use PagarMe\Sdk\Transaction\Request\CreditCardTransactionRefund;
use PagarMe\Sdk\Transaction\Request\BoletoTransactionRefund;
use PagarMe\Sdk\Account\Account;
use PagarMe\Sdk\Card\Card;
use PagarMe\Sdk\Customer\Customer;
use PagarMe\Sdk\SplitRule\SplitRuleCollection;
use PagarMe\Sdk\SplitRule\SplitRule;
use PagarMe\Sdk\Recipient\Recipient;

class TransactionHandler extends AbstractHandler
{
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

    public function boletoRefund(BoletoTransaction $transaction, Account $account, $amount = null)
    {
        $request = new BoletoTransactionRefund($transaction, $account, $amount);
        $response = $this->client->send($request);

        return $this->buildTransaction($response);
    }

    private function buildTransaction($transactionData)
    {
        if (isset($transactionData->split_rules)) {
            $transactionData->split_rules = $this->buildSplitRules(
                $transactionData->split_rules
            );
        }

        if ($transactionData->payment_method == BoletoTransaction::PAYMENT_METHOD) {
            return new BoletoTransaction(get_object_vars($transactionData));
        }

        if ($transactionData->payment_method == CreditCardTransaction::PAYMENT_METHOD) {
            return new CreditCardTransaction(get_object_vars($transactionData));
        }

        throw new UnsupportedTransaction(
            sprintf(
                'Transaction type: %s, is not supported',
                $transactionData->payment_method
            ),
            1
        );
    }

    private function buildSplitRules($splitRuleData)
    {
        $rules = new SplitRuleCollection();

        foreach ($splitRuleData as $rule) {
            $rule->recipient = new Recipient(['id' =>$rule->recipient_id]);
            $rules[] = new SplitRule(get_object_vars($rule));
        }

        return $rules;
    }
}
