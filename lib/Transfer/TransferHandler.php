<?php

namespace PagarMe\Sdk\Transfer;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Recipient\Recipient;
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\Transfer\Request\TransferCreate;
use PagarMe\Sdk\Transfer\Request\TransferGet;
use PagarMe\Sdk\Transfer\Request\TransferList;
use PagarMe\Sdk\Transfer\Request\TransferCancel;

class TransferHandler extends AbstractHandler
{
    /**
     * @param int amount
     * @param Recipient recipient
     * @param int id
     */
    public function create(
        $amount,
        Recipient $recipient,
        $bankAccountId = null
    ) {
        $request = new TransferCreate(
            $amount,
            $recipient,
            $bankAccountId
        );

        $result = $this->client->send($request);

        return $this->buildTransfer($result);
    }

    /**
     * @param int transferId
     */
    public function get($transferId)
    {
        $request = new TransferGet($transferId);

        $result = $this->client->send($request);

        return $this->buildTransfer($result);
    }

    /**
     * @param int page
     * @param int count
     */
    public function getList($page = null, $count = null)
    {
        $request = new TransferList($page, $count);

        $result = $this->client->send($request);

        $tranfers = [];

        foreach ($result as $transferData) {
            $tranfers[] = $this->buildTransfer($transferData);
        }

        return $tranfers;
    }

    /**
     * @param Transfer transfer
     */
    public function cancel(Transfer $transfer)
    {
        $request = new TransferCancel($transfer);

        $result = $this->client->send($request);

        return $this->buildTransfer($result);
    }

    /**
     * array transferData
     */
    private function buildTransfer($transferData)
    {
        $transferData->bank_account = new BankAccount(
            $transferData->bank_account
        );

        $transferData->funding_estimated_date = new \DateTime(
            $transferData->funding_estimated_date
        );
        $transferData->date_created = new \DateTime(
            $transferData->date_created
        );
        $transferData->funding_date = new \DateTime(
            $transferData->funding_date
        );

        return new Transfer(get_object_vars($transferData));
    }
}
