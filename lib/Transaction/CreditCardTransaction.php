<?php

namespace PagarMe\Sdk\Transaction;

class CreditCardTransaction extends AbstractTransaction
{
    const PAYMENT_METHOD = 'credit_card';

    /**
     * @var PagarMe\Sdk\Card\Card
     */
    protected $card;
    /**
     * @var int
     */
    protected $installments;
    /**
     * @var boolean
     */
    protected $capture;

    /**
     * @param array $transactionData
     */
    public function __construct($transactionData)
    {
        parent::__construct($transactionData);
        $this->paymentMethod = self::PAYMENT_METHOD;
    }

    /**
     * @return int
     */
    public function getCardId()
    {
        return $this->card->getId();
    }

    /**
     * @return string
     */
    public function getCardHash()
    {
        return $this->card->getHash();
    }

    /**
     * @return int
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     * @return boolean
     */
    public function isCapturable()
    {
        return (bool) $this->capture;
    }
}
