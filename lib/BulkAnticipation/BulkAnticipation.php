<?php

namespace PagarMe\Sdk\BulkAnticipation;

class BulkAnticipation
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
     * @var int
     */
    private $anticipationFee;

    /**
     * @var DateTime
     */
    private $dateCreated;

    /**
     * @var DateTime
     */
    private $dateUpdated;

    /**
     * @var int
     */
    private $fee;

    /**
     * @var DateTime
     */
    private $paymentDate;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $timeframe;

    /**
     * @var string
     */
    private $type;

    /**
     * @param array $bulkAnticipationData
     */
    public function __construct($bulkAnticipationData)
    {
        $this->fill($bulkAnticipationData);
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getAnticipationFee()
    {
        return $this->anticipationFee;
    }

    /**
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return string
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
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
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getTimeframe()
    {
        return $this->timeframe;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
