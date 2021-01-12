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
     * @var string
     */
    protected $softDescriptor;

    /**
     * @var \PagarMe\Sdk\PixAdditionalField\PixAdditionalFieldCollection
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
     * @return \DateTime
     * @codeCoverageIgnore
     */
    public function getPixExpirationDate()
    {
        return $this->pixExpirationDate;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getPixQrCode()
    {
        return $this->pixQrCode;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getSoftDescriptor()
    {
        return $this->softDescriptor;
    }

    /**
     * @return \PagarMe\Sdk\PixAdditionalField\PixAdditionalFieldCollection
     * @codeCoverageIgnore
     */
    public function getPixAdditionalFields()
    {
        return $this->pixAdditionalFields;
    }
}
