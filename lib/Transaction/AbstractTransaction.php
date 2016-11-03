<?php

namespace PagarMe\Sdk\Transaction;

use PagarMe\Sdk\SplitRule\SplitRuleCollection;
use PagarMe\Sdk\SplitRule\SplitRule;

abstract class AbstractTransaction
{
    use \PagarMe\Sdk\Fillable;

    const PROCESSING      = 'processing';
    const AUTHORIZED      = 'authorized';
    const PAID            = 'paid';
    const REFUNDED        = 'refunded';
    const WAITING_PAYMENT = 'waiting_payment';
    const PENDING_REFUND  = 'pending_refund';
    const REFUSED         = 'refused';

    protected $id;
    protected $status;
    protected $refuseReason;
    protected $statusReason;
    protected $acquirerName;
    protected $acquirerResponseCode;
    protected $authorizationCode;
    protected $softDescriptor;
    protected $tid;
    protected $nsu;
    protected $dateCreated;
    protected $dateUpdated;
    protected $amount;
    protected $cost;
    protected $postbackUrl;
    protected $paymentMethod;
    protected $antifraudScore;
    protected $referer;
    protected $ip;
    protected $subscriptionId;
    protected $phone;
    protected $address;
    protected $customer;
    protected $metadata;
    protected $paidAmount;
    protected $refundedAmount;
    protected $splitRules;

    public function __construct($transactionData)
    {
        $this->fill($transactionData);
    }

    /**
    * @codeCoverageIgnore
    */
    public function getId()
    {
        return $this->id;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getStatus()
    {
        return $this->status;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getRefuseReason()
    {
        return $this->refuseReason;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getStatusReason()
    {
        return $this->statusReason;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getAcquirerName()
    {
        return $this->acquirerName;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getAcquirerResponseCode()
    {
        return $this->acquirerResponseCode;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getSoftDescriptor()
    {
        return $this->softDescriptor;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getTid()
    {
        return $this->tid;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getNsu()
    {
        return $this->nsu;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getCost()
    {
        return $this->cost;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getPostbackUrl()
    {
        return $this->postbackUrl;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getAntifraudScore()
    {
        return $this->antifraudScore;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getIp()
    {
        return $this->ip;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getAddress()
    {
        return $this->address;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getCard()
    {
        return $this->card;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }

    /**
    * @codeCoverageIgnore
    */
    public function getRefundedAmount()
    {
        return $this->refundedAmount;
    }

    /**
    * @codeCoverageIgnore
    */
    public function isProcessing()
    {
        return $this->status == self::PROCESSING;
    }

    /**
    * @codeCoverageIgnore
    */
    public function isAuthorized()
    {
        return $this->status == self::AUTHORIZED;
    }

    /**
    * @codeCoverageIgnore
    */
    public function isPaid()
    {
        return $this->status == self::PAID;
    }

    /**
    * @codeCoverageIgnore
    */
    public function isRefunded()
    {
        return $this->status == self::REFUNDED;
    }

    /**
    * @codeCoverageIgnore
    */
    public function isWaitingPayment()
    {
        return $this->status == self::WAITING_PAYMENT;
    }

    /**
    * @codeCoverageIgnore
    */
    public function isPendingRefund()
    {
        return $this->status == self::PENDING_REFUND;
    }

    /**
    * @codeCoverageIgnore
    */
    public function isRefused()
    {
        return $this->status == self::REFUSED;
    }

    /**
     * @return SplitRuleCollection
     */
    public function getSplitRules()
    {
        return $this->splitRules;
    }
}
