<?php

namespace PagarMe\Sdk\Postback;

class Delivery
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var string
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
    private $responseBody;

    /**
     * @var string
     */
    private $responseHeaders;

    /**
     * @var int
     */
    private $responseTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $statusReason;

    /**
     * @param array $postbackDeliveryData
     */
    public function __construct($postbackDeliveryData)
    {
        $this->fill($postbackDeliveryData);
    }

    /**
     * @return string
     */
    public function getId()
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
     * @return string
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * @return string
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * @return int
     */
    public function getResponseTime()
    {
        return $this->responseTime;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getStatusReason()
    {
        return $this->statusReason;
    }
}
