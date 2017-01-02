<?php

namespace PagarMe\Sdk\BalanceOperations;

class Operation
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
    protected $balanceAmount;

    /**
     * @var int
     */
    protected $balanceOldAmount;

    /**
     * @var string
     */
    protected $movementType;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @var int
     */
    protected $fee;

    /**
     * @var \DateTime
     */
    protected $dateCreated;

    /**
     * @var Movement
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
     * @return \DateTime
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
