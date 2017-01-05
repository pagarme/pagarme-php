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
    use \PagarMe\Sdk\Recipient\RecipientBuilder;
    use \PagarMe\Sdk\BalanceOperations\OperationBuilder;

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

        $result = $this->client->send($request);

        return $this->buildRecipient($result);
    }

    /**
     * @param int $page
     * @param int $count
     * @return array
     */
    public function getList($page = null, $count = null)
    {
        $request = new RecipientList($page, $count);

        $result = $this->client->send($request);

        $recipients = [];
        foreach ($result as $recipientData) {
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

        $result = $this->client->send($request);

        return $this->buildRecipient($result);
    }

    /**
     * @param Recipient $recipient
     * @return Recipient
     */
    public function update(Recipient $recipient)
    {
        $request = new RecipientUpdate($recipient);

        $result = $this->client->send($request);

        return $this->buildRecipient($result);
    }

    /**
     * @param Recipient $recipient
     * @return Balance
     */
    public function balance(Recipient $recipient)
    {
        $request = new RecipientBalance($recipient);

        $result = $this->client->send($request);

        return new Balance($result);
    }

    /**
     * @param Recipient $recipient
     * @param int $operationId
     * @return Operation
     */
    public function balanceOperation(Recipient $recipient, $operationId)
    {
        $request = new RecipientBalanceOperation($recipient, $operationId);

        $result = $this->client->send($request);

        return $this->buildOperation($result);
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

        $result = $this->client->send($request);
        $operations = [];

        foreach ($result as $operation) {
            $operations[] = $this->buildOperation($operation);
        }

        return $operations;
    }
}
