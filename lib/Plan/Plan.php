<?php

namespace PagarMe\Sdk\Plan;

class Plan
{
    use \PagarMe\Sdk\Fillable;

    /**
    * @var int
    **/
    private $amount;

    /**
    * @var int
    **/
    private $id;

    /**
    * @var int
    **/
    private $days;

    /**
    * @var string
    **/
    private $name;

    /**
    * @var int
    **/
    private $trialDays;

    /**
    * @var array
    **/
    private $paymentMethods;

    /**
    * @var string
    **/
    private $color;

    /**
    * @var int
    **/
    private $charges;

    /**
    * @var int
    **/
    private $installments;


    /**
    * @param array $planData
    */
    public function __construct($planData)
    {
        $this->fill($planData);
    }

    /**
    * @return int
    **/
    public function getId()
    {
        return $this->id;
    }

    /**
    * @return int
    **/
    public function getAmount()
    {
        return $this->amount;
    }

    /**
    * @return int
    **/
    public function getDays()
    {
        return $this->days;
    }

    /**
    * @return string
    **/
    public function getName()
    {
        return $this->name;
    }

    /**
    * @return int
    **/
    public function getTrialDays()
    {
        return $this->trialDays;
    }

    /**
    * @return array
    **/
    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }

    /**
    * @return string
    **/
    public function getColor()
    {
        return $this->color;
    }

    /**
    * @return int
    **/
    public function getCharges()
    {
        return $this->charges;
    }

    /**
    * @return int
    **/
    public function getInstallments()
    {
        return $this->installments;
    }
}
