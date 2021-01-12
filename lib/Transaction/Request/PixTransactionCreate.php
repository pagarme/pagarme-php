<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Transaction\PixTransaction;
use PagarMe\Sdk\PixAdditionalField\PixAdditionalFieldCollection;

class PixTransactionCreate extends TransactionCreate
{
    use \PagarMe\Sdk\PixAdditionalFieldSerializer;

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
            'soft_descriptor' => $this->transaction->getSoftDescriptor(),
        ];

        if ($this->transaction->getPixAdditionalFields() instanceof PixAdditionalFieldCollection) {
            $pixData['pix_additional_fields'] = $this->getPixAdditionalFieldsInfo(
                $this->transaction->getPixAdditionalFields()
            );
        }

        return array_merge($basicData, $pixData);
    }
}
