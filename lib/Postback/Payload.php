<?php

namespace PagarMe\Sdk\Postback;

class Postback
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $fingerprint;

    /**
     * @var string
     */
    private $event;

    /**
     * @var string
     */
    private $old_status;

    /**
     * @var string
     */
    private $desired_status;

    /**
     * @var string
     */
    private $current_status;

    /**
     * @var AbstractTransaction
     */
    private $transaction;

    /**
     * @var int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * @var string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @var string
     */
    public function getOldStatus()
    {
        return $this->oldStatus;
    }

    /**
     * @var string
     */
    public function getDesiredStatus()
    {
        return $this->desiredStatus;
    }

    /**
     * @var string
     */
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * @var AbstractTransaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }
}
