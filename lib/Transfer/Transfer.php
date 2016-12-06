<?php

namespace PagarMe\Sdk\Transfer;

class Transfer
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var int
     **/
    private $id;

    /**
     * @var int
     **/
    private $amount;

    /**
     * @var string
     **/
    private $type;

    /**
     * @var string
     **/
    private $status;

    /**
     * @var int
     **/
    private $fee;

    /**
     * @var string
     **/
    private $fundingEstimatedDate;

    /**
     * @var PagarMe\Sdk\BankAccount\BankAccount
     **/
    private $bankAccount;

    /**
     * @var string
     **/
    private $dateCreated;

    /**
     * @param array $arrayData
     **/
    public function __construct($arrayData)
    {
        $this->fill($arrayData);
    }

    /**
     * @return int $id
     **/
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int $amount
     **/
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string $type
     **/
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string $status
     **/
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int $fee
     **/
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @return string $fundingEstimatedDate
     **/
    public function getFundingEstimatedDate()
    {
        return $this->fundingEstimatedDate;
    }

    /**
     * @return PagarMe\Sdk\BankAccount\BankAccount $bankAccount
     **/
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @return string $dateCreated
     **/
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
}
