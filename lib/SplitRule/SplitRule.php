<?php

namespace PagarMe\Sdk\SplitRule;

use PagarMe\Sdk\Recipient\Recipient;

class SplitRule
{

    use \PagarMe\Sdk\Fillable;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Recipient
     */
    private $recipient;

    /**
     * @var bool
     */
    private $chargeProcessingFee;
    /**
     * @var bool
     */
    private $liable;
    /**
     * @var int
     */
    private $percentage;
    /**
     * @var int
     */
    private $amount;
    /**
     * @var \DateTime
     */
    private $dateCreated;
    /**
     * @var \DateTime
     */
    private $dateUpdated;

    public function __construct($ruleData)
    {
        $this->setRecipient($ruleData['recipient']);
        unset($ruleData['recipient']);

        $this->fill($ruleData);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param Recipient $recipient
     */
    public function setRecipient(Recipient $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return bool
     */
    public function getChargeProcessingFee()
    {
        return $this->chargeProcessingFee;
    }

    /**
     * @return bool
     */
    public function getLiable()
    {
        return $this->liable;
    }

    /**
     * @return int
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
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
}
