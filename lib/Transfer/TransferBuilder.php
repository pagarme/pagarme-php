<?php

namespace PagarMe\Sdk\Transfer;

use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\Recipient\Recipient;

trait TransferBuilder
{
    /**
     * @param array transferData
     * @return Transfer
     */
    private function buildTransfer($transferData)
    {

        if (property_exists($transferData, 'bank_account')) {
            $transferData->bank_account = new BankAccount(
                $transferData->bank_account
            );
        }

        if (property_exists($transferData, 'recipient')) {
            $transferData->bank_account = new BankAccount(
                $transferData->recipient->bank_account
            );
            
            $transferData->recipient->bank_account = $transferData->bank_account;
            
            $transferData->recipient = new Recipient(
                $transferData->recipient
            );
        }

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
