<?php

namespace PagarMe\Sdk\Transaction;

class BoletoTransaction extends AbstractTransaction
{
    const PAYMENT_METHOD = 'boleto';

    /**
     * @var \DateTime
     */
    protected $boletoExpirationDate;

    /**
     * @param array $transactionData
     */
    public function __construct($transactionData)
    {
        parent::__construct($transactionData);
        $this->paymentMethod = self::PAYMENT_METHOD;
    }

    /**
     * @return \DateTime
     */
    public function getBoletoExpirationDate()
    {
        return $this->boletoExpirationDate;
    }
}
