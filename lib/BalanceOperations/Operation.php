<?php

namespace PagarMe\Sdk\BalanceOperations;

class Operation
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
     * @var balanceAmount int
     */
    protected $balanceAmount;

    /**
     * @var balanceOldAmount int
     */
    protected $balanceOldAmount;

    /**
     * @var movementType string
     */
    protected $movementType;

    /**
     * @var amount int
     */
    protected $amount;

    /**
     * @var fee int
     */
    protected $fee;

    /**
     * @var dateCreated string
     */
    protected $dateCreated;

    /**
     * @var movement Movement
     */
    protected $movement;

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
    public function getBalanceAmount()
    {
        return $this->balanceAmount;
    }

    /**
     * @return int
     */
    public function getBalanceOldAmount()
    {
        return $this->balanceOldAmount;
    }

    /**
     * @return string
     */
    public function getMovementType()
    {
        return $this->movementType;
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
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return Movement
     */
    public function getMovement()
    {
        return $this->movement;
    }
}
