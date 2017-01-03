<?php

namespace PagarMe\Sdk\Card;

class Card
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var \DateTime
     */
    private $dateUpdated;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $holderName;

    /**
     * @var string
     */
    private $firstDigits;

    /**
     * @var string
     */
    private $lastDigits;

    /**
     * @var string
     */
    private $fingerprint;

    /**
     * @var object
     */
    private $customer;

    /**
     * @var boolean
     */
    private $valid;

    /**
     * @var string
     */
    private $hash;

    /**
     * @param array $arrayData
     */
    public function __construct($arrayData)
    {
        $this->fill($arrayData);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstDigits()
    {
        return $this->firstDigits;
    }

    /**
     * @return string
     */
    public function getLastDigits()
    {
        return $this->lastDigits;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getHolderName()
    {
        return $this->holderName;
    }

    /**
     * @return string
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * @return object
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return boolean
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
}
