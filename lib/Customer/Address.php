<?php

namespace PagarMe\Sdk\Customer;

class Address
{

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $streetNumber;

    /**
     * @var string
     */
    private $neighborhood;

    /**
     * @var string
     */
    private $zipcode;

    /**
     * @var string
     */
    private $complementary;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $country;

    /**
     * @param string $street
     * @param string $streetNumber
     * @param string $neighborhood
     * @param string $zipcode
     */
    public function __construct($street, $streetNumber, $neighborhood, $zipcode)
    {
        $this->street       = $street;
        $this->streetNumber = $streetNumber;
        $this->neighborhood = $neighborhood;
        $this->zipcode      = $zipcode;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * @return string
     */
    public function getNeighborhood()
    {
        return $this->neighborhood;
    }

    /**
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param string $complementary
     * @return Address
     */
    public function setComplementary($complementary)
    {
        $this->complementary = $complementary;
        return $this;
    }

    /**
     * @return string
     */
    public function getComplementary()
    {
        return $this->complementary;
    }

    /**
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $state
     * @return Address
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $country
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}
