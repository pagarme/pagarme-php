<?php

namespace PagarMe\Sdk\Transfer;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Recipient\Recipient;
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\Transfer\Request\TransactionRecipientCreate;

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

        $result->bank_account = new BankAccount($result->bank_account);

        return new Transfer(get_object_vars($result));
    }
}
