<?php

namespace PagarMe\Sdk\Subscription\Request;

use PagarMe\Sdk\RequestInterface;
use PagarMe\Sdk\Plan\Plan;
use PagarMe\Sdk\Customer\Customer;
use PagarMe\Sdk\SplitRule\SplitRuleCollection;

abstract class SubscriptionCreate implements RequestInterface
{
    /**
     * @var Plan $plan
     */
    protected $plan;

    /**
     * @var Customer $customer
     */
    protected $customer;

    /**
     * @var string $postbackUrl
     */
    protected $postbackUrl;

    /**
     * @var array $metadata
     */
    protected $metadata;

    /**
     * @var string $paymentMethod
     */
    protected $paymentMethod;

    /**
     * @var array $extraAttributes
     */
    protected $extraAttributes;

    /**
     * @var Plan $plan
     * @var Customer $customer
     * @var string $postbackUrl
     * @var array $metadata
     */
    public function __construct(
        Plan $plan,
        Customer $customer,
        $postbackUrl,
        $metadata,
        $extraAttributes
    ) {
        $this->plan            = $plan;
        $this->customer        = $customer;
        $this->postbackUrl     = $postbackUrl;
        $this->metadata        = $metadata;
        $this->extraAttributes = $extraAttributes;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        $payload = [
            'plan_id'        => $this->plan->getId(),
            'payment_method' => $this->paymentMethod,
            'metadata'       => $this->metadata,
            'customer'       => [
                'name'            => $this->customer->getName(),
                'email'           => $this->customer->getEmail(),
                'document_number' => $this->customer->getDocumentNumber(),
                'born_at'         => $this->customer->getBornAt(),
                'gender'          => $this->customer->getGender()
            ],
            'postback_url' => $this->postbackUrl
        ];

        if (!is_null($this->customer->getAddress())) {
            $payload['customer']['address'] = $this->getAddresssData();
        }

        if (!is_null($this->customer->getPhone())) {
            $payload['customer']['phone'] = $this->getPhoneData();
        }

        if (array_key_exists('split_rules', $this->extraAttributes)
            && $this->extraAttributes['split_rules'] instanceof SplitRuleCollection) {
            $payload['split_rules'] = $this->getSplitRulesInfo();
        }

        return $payload;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'subscriptions';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_POST;
    }

    /**
     *  @return array
     */
    protected function getAddresssData()
    {
        $address = $this->customer->getAddress();

        $addressData = [
            'street'        => $address->getStreet(),
            'street_number' => $address->getStreetNumber(),
            'neighborhood'  => $address->getNeighborhood(),
            'zipcode'       => $address->getZipcode()
        ];

        if (!is_null($address->getComplementary())) {
            $addressData['complementary'] = $address->getComplementary();
        }

        if (!is_null($address->getCity())) {
            $addressData['city'] = $address->getCity();
        }

        if (!is_null($address->getState())) {
            $addressData['state'] = $address->getState();
        }

        if (!is_null($address->getCountry())) {
            $addressData['country'] = $address->getCountry();
        }

        return $addressData;
    }

    /**
     *  @return array
     */
    protected function getPhoneData()
    {
        $phone = $this->customer->getPhone();

        $phoneData = [
            'ddd'    => $phone->getDdd(),
            'number' => $phone->getNumber()
        ];

        if (!is_null($phone->getDdi())) {
            $phoneData['ddi'] = $phone->getDdi();
        }

        return $phoneData;
    }

    /**
     * @param \PagarMe\Sdk\SplitRule\SplitRuleCollection $splitRules
     * @return array
     */
    private function getSplitRulesInfo()
    {
        $rules = [];

        foreach ($this->extraAttributes['split_rules'] as $key => $splitRule) {
            $rule = [
                'recipient_id'          => $splitRule->getRecipient()->getId(),
                'charge_processing_fee' => $splitRule->getChargeProcessingFee(),
                'charge_remainder_fee' => $splitRule->getChargeRemainder(),
                'liable'                => $splitRule->getLiable()
            ];

            $rules[$key] = array_merge($rule, $this->getRuleValue($splitRule));
        }

        return $rules;
    }

    /**
     * @param \PagarMe\Sdk\SplitRule\SplitRule $splitRule
     * @return array
     */
    private function getRuleValue($splitRule)
    {
        if (is_null($splitRule->getAmount())) {
            return ['percentage' => $splitRule->getPercentage()];
        }

        return ['amount' => $splitRule->getAmount()];
    }
}
