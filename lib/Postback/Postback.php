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
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var \DateTime
     */
    private $dateUpdated;

    /**
     * @var array
     */
    private $deliveries;

    /**
     * @var string
     */
    private $headers;

    /**
     * @var string
     */
    private $model;

    /**
     * @var int
     */
    private $modelId;

    /**
     * @var \DateTime
     */
    private $nextRetry;

    /**
     * @var string
     */
    private $payload;

    /**
     * @var string
     */
    private $requestUrl;

    /**
     * @var int
     */
    private $retries;

    /**
     * @var string
     */
    private $signature;

    /**
     * @var string
     */
    private $status;

    /**
     * @param array $postbackData
     */
    public function __construct($postbackData)
    {
        $this->fill($postbackData);
    }

    /**
     * @return int
     */
    public function getID()
    {
        return $this->id;
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
     * @return array
     */
    public function getDeliveries()
    {
        return $this->deliveries;
    }

    /**
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return int
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * @return \DateTime
     */
    public function getNextRetry()
    {
        return $this->nextRetry;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * @return int
     */
    public function getRetries()
    {
        return $this->retries;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
