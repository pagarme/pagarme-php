<?php

namespace PagarMe\Sdk\Transfer;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Recipient\Recipient;
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\Transfer\Request\TransactionRecipientCreate;
use PagarMe\Sdk\Transfer\Request\TransferGet;

class TransferHandler extends AbstractHandler
{
    /**
     * @param int amount
     * @param Recipient $recipient
     **/
    public function create(
        $amount,
        Recipient $recipient,
        $bankAccountId = null
    ) {
        $request = new TransactionRecipientCreate(
            $amount,
            $recipient,
            $bankAccountId
        );

        $result = $this->client->send($request);

        return $this->buildTransfer($result);
    }

    /**
     * @param int transferId
     **/
    public function get($transferId)
    {
        $request = new TransferGet($transferId);

        $result = $this->client->send($request);

        return $this->buildTransfer($result);
    }

    private function buildTransfer($transferData)
    {
        $transferData->bank_account = new BankAccount(
            $transferData->bank_account
        );

        return new Transfer(get_object_vars($transferData));
    }
}
