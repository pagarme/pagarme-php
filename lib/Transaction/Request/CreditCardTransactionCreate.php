<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Transaction\CreditCardTransaction;

class CreditCardTransactionCreate extends TransactionCreate
{
    public function __construct(CreditCardTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function getPayload()
    {
        $basicData = parent::getPayload();
        $cardData = [
            'installments' => $this->transaction->getInstallments(),
            'capture'      => $this->transaction->isCapturable()
        ];

        return array_merge($basicData, $cardData, $this->getCardInfo());
    }

    /**
     * @return array
     */
    private function getCardInfo()
    {
        if (!is_null($this->transaction->getCardId())) {
            return ['card_id' => $this->transaction->getCardId()];
        }

        if (!is_null($this->transaction->getCardHash())) {
            return ['card_hash' => $this->transaction->getCardHash()];
        }
    }
}
