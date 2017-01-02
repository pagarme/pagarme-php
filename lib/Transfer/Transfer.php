<?php

namespace PagarMe\Sdk\Transfer;

class Transfer
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $fee;

    /**
     * @var \DateTime
     */
    private $fundingEstimatedDate;

    /**
     * @var PagarMe\Sdk\BankAccount\BankAccount
     */
    private $bankAccount;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var string
     */
    private $sourceType;

    /**
     * @var string
     */
    private $sourceId;

    /**
     * @var string
     */
    private $targetType;

    /**
     * @var int
     */
    private $targetId;

    /**
     * @var \DateTime
     */
    private $fundingDate;


    /**
     * @param array $arrayData
     */
    public function __construct($arrayData)
    {
        $this->fill($arrayData);
    }

    /**
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int $fee
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @return \DateTime
     */
    public function getFundingEstimatedDate()
    {
        return $this->fundingEstimatedDate;
    }

    /**
     * @return PagarMe\Sdk\BankAccount\BankAccount $bankAccount
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
    * @return string
    */
    public function getSourceType()
    {
        return $this->sourceType;
    }

    /**
    * @return string
    */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
    * @return string
    */
    public function getTargetType()
    {
        return $this->targetType;
    }

    /**
    * @return int
    */
    public function getTargetID()
    {
        return $this->targetId;
    }

    /**
    * @return \DateTime
    */
    public function getFundingDate()
    {
        return $this->fundingDate;
    }
}
