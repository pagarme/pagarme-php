<?php

namespace PagarMe\Sdk\SplitRule;

use PagarMe\Sdk\Recipient\Recipient;

class SplitRule
{

    use \PagarMe\Sdk\Fillable;

    /**
     * @var int $id
     **/
    private $id;

    /**
     * @var Recipient recipient
     **/
    private $recipient;

    /**
     * @var bool chargeProcessingFee
     **/
    private $chargeProcessingFee;
    /**
     * @var bool liable
     **/
    private $liable;
    /**
     * @var int percentage
     **/
    private $percentage;
    /**
     * @var int amount
     **/
    private $amount;
    /**
     * @var string dateCreated
     **/
    private $dateCreated;
    /**
     * @var string dateUpdated
     **/
    private $dateUpdated;

    public function __construct($ruleData)
    {
        $this->setRecipient($ruleData['recipient']);
        unset($ruleData['recipient']);

        $this->fill($ruleData);
    }

    /**
     * @return int
     **/
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Recipient
     **/
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param Recipient $recipient
     **/
    public function setRecipient(Recipient $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return bool
     **/
    public function getChargeProcessingFee()
    {
        return $this->chargeProcessingFee;
    }

    /**
     * @return bool
     **/
    public function getLiable()
    {
        return $this->liable;
    }

    /**
     * @return int
     **/
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @return int
     **/
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     **/
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return string
     **/
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }
}
