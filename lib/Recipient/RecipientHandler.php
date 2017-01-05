<?php

namespace PagarMe\Sdk\Recipient;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\Recipient\Request\RecipientCreate;
use PagarMe\Sdk\Recipient\Request\RecipientList;
use PagarMe\Sdk\Recipient\Request\RecipientGet;
use PagarMe\Sdk\Recipient\Request\RecipientUpdate;
use PagarMe\Sdk\Recipient\Request\RecipientBalance;
use PagarMe\Sdk\Recipient\Request\RecipientBalanceOperation;
use PagarMe\Sdk\Recipient\Request\RecipientBalanceOperations;
use PagarMe\Sdk\Balance\Balance;
use PagarMe\Sdk\BalanceOperations\Operation;
use PagarMe\Sdk\BalanceOperations\Movement;

class RecipientHandler extends AbstractHandler
{
    /**
     * @param BankAccount $bankAccount
     * @param string $transferInterval
     * @param int $transferDay
     * @param bool $transferEnabled
     * @param bool $automaticAnticipationEnabled
     * @param int $anticipatableVolumePercentage
     * @return Recipient
     */
    public function create(
        BankAccount $bankAccount,
        $transferInterval = null,
        $transferDay = null,
        $transferEnabled = null,
        $automaticAnticipationEnabled = null,
        $anticipatableVolumePercentage = null
    ) {
        $request = new RecipientCreate(
            $bankAccount,
            $transferInterval,
            $transferDay,
            $transferEnabled,
            $automaticAnticipationEnabled,
            $anticipatableVolumePercentage
        );

        $response = $this->client->send($request);

        return $this->buildRecipient($response);
    }

    /**
     * @param int $page
     * @param int $count
     * @return array
     */
    public function getList($page = null, $count = null)
    {
        $request = new RecipientList($page, $count);

        $response = $this->client->send($request);

        $recipients = [];
        foreach ($response as $recipientData) {
            $recipients[] = $this->buildRecipient($recipientData);
        }

        return $recipients;
    }

    /**
     * @param int $recipientId
     * @param int $count
     * @return Recipient
     */
    public function get($recipientId)
    {
        $request = new RecipientGet($recipientId);

        $response = $this->client->send($request);

        return $this->buildRecipient($response);
    }

    /**
     * @param Recipient $recipient
     * @return Recipient
     */
    public function update(Recipient $recipient)
    {
        $request = new RecipientUpdate($recipient);

        $response = $this->client->send($request);

        return $this->buildRecipient($response);
    }

    /**
     * @param Recipient $recipient
     * @return Balance
     */
    public function balance(Recipient $recipient)
    {
        $request = new RecipientBalance($recipient);

        $response = $this->client->send($request);

        return new Balance($response);
    }

    /**
     * @param Recipient $recipient
     * @param int $operationId
     * @return Operation
     */
    public function balanceOperation(Recipient $recipient, $operationId)
    {
        $request = new RecipientBalanceOperation($recipient, $operationId);

        $response = $this->client->send($request);

        $response->movement = new Movement($response->movement_object);

        return new Operation(get_object_vars($response));
    }

    /**
     * @param Recipient $recipient
     * @param int $page
     * @param int $count
     * @return array
     */
    public function balanceOperations(
        Recipient $recipient,
        $page = null,
        $count = null
    ) {
        $request = new RecipientBalanceOperations($recipient, $page, $count);

        $response = $this->client->send($request);
        $operations = [];

        foreach ($response as $operation) {
            $operation->movement = new Movement($operation->movement_object);
            $operations[]= new Operation(get_object_vars($operation));
        }

        return $operations;
    }

    /**
     * @param array $recipientData
     * @return Recipient
     */
    private function buildRecipient($recipientData)
    {
        $recipientData->date_created = new \DateTime(
            $recipientData->date_created
        );

        $recipientData->date_updated = new \DateTime(
            $recipientData->date_updated
        );

        $recipientData->bank_account = new BankAccount(
            get_object_vars($recipientData->bank_account)
        );

        return new Recipient($recipientData);
    }
}
