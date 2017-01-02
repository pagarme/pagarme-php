<?php

namespace PagarMe\Sdk\Balance;

class Balance
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var waitingFunds int
     */
    protected $waitingFunds;

    /**
     * @var available int
     */
    protected $available;

    /**
     * @var transferred int
     */
    protected $transferred;

    public function __construct($recipientData)
    {
        $this->fill($recipientData);
    }

    /**
     * @return int
     */
    public function getWaitingFunds()
    {
        return $this->waitingFunds;
    }

    /**
     * @return int
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @return int
     */
    public function getTransferred()
    {
        return $this->transferred;
    }
}
