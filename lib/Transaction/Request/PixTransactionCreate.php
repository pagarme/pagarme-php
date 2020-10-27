<?php

namespace PagarMe\Sdk\Transaction\Request;


use PagarMe\Sdk\Transaction\PixTransaction;

class PixTransactionCreate extends TransactionCreate
{
    /**
     * @param PixTransaction $transaction
     */
    public function __construct(PixTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * return array
     */
    public function getPayload()
    {
        $basicData = parent::getPayload();

        $pixData = [
            'pix_expiration_date' => $this->transaction->getPixExpirationDate(),
            'pix_additional_fields' => $this->transaction->getPixAdditionalFields()
        ];

        return array_merge($basicData, $pixData);
    }
}