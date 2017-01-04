<?php

namespace PagarMe\Sdk\Plan\Request;

use PagarMe\Sdk\Request;

class PlanCreate implements Request
{

    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $days;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $trialDays;

    /**
     * @var array
     */
    private $paymentsMethods;

    /**
     * @var string
     */
    private $color;

    /**
     * @var int
     */
    private $charges;

    /**
     * @var int
     */
    private $installments;


    /**
     * @param int $amount
     * @param int $days
     * @param string $name
     * @param int $trialDays
     * @param array $paymentsMethods
     * @param string $color
     * @param int $charges
     * @param int $installments
     */
    public function __construct(
        $amount,
        $days,
        $name,
        $trialDays,
        $paymentsMethods,
        $color,
        $charges,
        $installments
    ) {
        $this->amount          = $amount;
        $this->days            = $days;
        $this->name            = $name;
        $this->trialDays       = $trialDays;
        $this->paymentsMethods = $paymentsMethods;
        $this->color           = $color;
        $this->charges         = $charges;
        $this->installments    = $installments;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [
            'amount'           => $this->amount,
            'days'             => $this->days,
            'name'             => $this->name,
            'trial_days'       => $this->trialDays,
            'payment_methods' => $this->paymentsMethods,
            'color'            => $this->color,
            'charges'          => $this->charges,
            'installments'     => $this->installments
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'plans';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'POST';
    }
}
