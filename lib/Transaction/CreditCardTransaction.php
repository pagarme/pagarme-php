<?php

namespace PagarMe\Sdk\Transaction;

class CreditCardTransaction extends Transaction
{
    const PAYMENT_METHOD = 'credit_card';

    protected $card;
    protected $installments;

    public function __construct($arrayData)
    {
        parent::__construct($arrayData);
        $this->paymentMethod = self::PAYMENT_METHOD;
    }

    public function getCardId()
    {
        return $this->card->getId();
    }

    public function getInstallments()
    {
        return $this->installments;
    }
}