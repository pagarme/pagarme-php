<?php

namespace PagarMe\Sdk\BalanceOperations;

class Movement
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @var int
     */
    protected $fee;

    /**
     * @var int
     */
    protected $installment;

    /**
     * @var int
     */
    protected $transactionId;

    /**
     * @var \DateTime
     */
    protected $paymentDate;

    /**
     * @var \DateTime
     */
    protected $dateCreated;

    public function __construct($recipientData)
    {
        $this->fill($recipientData);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @return int
     */
    public function getInstallment()
    {
        return $this->installment;
    }

    /**
     * @return int
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
}
