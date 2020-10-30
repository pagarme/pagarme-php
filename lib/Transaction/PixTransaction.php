<?php

namespace PagarMe\Sdk\Transaction;

class PixTransaction extends AbstractTransaction
{
    const PAYMENT_METHOD = 'pix';

    /**
     * @var string
     */
    protected $pixQrCode;

    /**
     * @var \DateTime
     */
    protected $pixExpirationDate;

    /**
     * @var array
     */
    protected $pixAdditionalFields;

    /**
     * @param array $transactionData
     */
    public function __construct($transactionData)
    {
        parent::__construct($transactionData);
        $this->paymentMethod = self::PAYMENT_METHOD;
    }

    /**
     * @return string
     */
    public function getPixQrCode()
    {
        return $this->pixQrCode;
    }

    /**
     * @return \DateTime
     */
    public function getPixExpirationDate()
    {
        return $this->pixExpirationDate;
    }

    /**
     * @return array
     */
    public function getPixAdditionalFields()
    {
        return $this->pixAdditionalFields;
    }
}
