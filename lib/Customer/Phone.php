<?php

namespace PagarMe\Sdk\Customer;

class Phone
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var int $ddd
     */
    private $ddd;

    /**
     * @var int $number
     */
    private $number;

    /**
     * @var int $ddi
     */
    private $ddi;

    /**
     * @param array $phoneData
     */
    public function __construct($phoneData)
    {
        $this->fill($phoneData);
    }

    /**
     * @return int
     */
    public function getDdd()
    {
        return $this->ddd;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return int
     */
    public function getDdi()
    {
        return $this->ddi;
    }
}
