<?php

namespace PagarMe\Sdk\BalanceOperations;

class Movement
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var id int
     */
    protected $id;

    /**
     * @var status string
     */
    protected $status;

    /**
     * @var amount int
     */
    protected $amount;

    /**
     * @var fee int
     */
    protected $fee;

    /**
     * @var installment int
     */
    protected $installment;

    /**
     * @var transactionId int
     */
    protected $transactionId;

    /**
     * @var paymentDate string
     */
    protected $paymentDate;

    /**
     * @var dateCreated string
     */
    protected $dateCreated;

    public function __construct($recipientData)
    {
        $this->fill($recipientData);
    }

    /**
     * @return int
     */
    public function getID()
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
    public function getTransactionID()
    {
        return $this->transactionID;
    }

    /**
     * @return string
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
}
