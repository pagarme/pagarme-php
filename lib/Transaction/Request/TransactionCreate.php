<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Transaction\Transaction;
use PagarMe\Sdk\SplitRule\SplitRuleCollection;
use PagarMe\Sdk\SplitRule\SplitRule;

class TransactionCreate implements Request
{
    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        $customer = $this->transaction->getCustomer();

        $address  = $customer->getAddress();
        $phone    = $customer->getPhone();

        $transactionData = [
            'amount'         => $this->transaction->getAmount(),
            'payment_method' => $this->transaction->getPaymentMethod(),
            'postback_url'   => $this->transaction->getPostbackUrl(),
            'customer' => [
                'name'            => $customer->getName(),
                'document_number' => $customer->getDocumentNumber(),
                'email'           => $customer->getEmail(),
                'sex'             => $customer->getGender(),
                'born_at'         => $customer->getBornAt(),
                'address' => [
                    'street'        => $address['street'],
                    'street_number' => $address['street_number'],
                    'complementary' => isset($address['complementary']) ? $address['complementary']: null,
                    'neighborhood'  => $address['neighborhood'],
                    'zipcode'       => $address['zipcode']
                ],
                'phone' => [
                    'ddd'    => (string) $phone['ddd'],
                    'number' => (string) $phone['number']
                ]
            ],
            'metadata' => $this->transaction->getMetadata()
        ];

        if ($this->transaction->getSplitRules() instanceof SplitRuleCollection) {
            $transactionData['split_rules'] = $this->getSplitRulesInfo(
                $this->transaction->getSplitRules()
            );
        }

        return $transactionData;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'transactions';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_POST;
    }

    /**
     * @param PagarMe\Sdk\SplitRule\SplitRuleCollection $splitRules
     * @return array
     */
    private function getSplitRulesInfo(SplitRuleCollection $splitRules)
    {
        $rules = [];

        foreach ($splitRules as $key => $splitRule) {
            $rule = [
                'recipient_id'          => $splitRule->getRecipient()->getId(),
                'charge_processing_fee' => $splitRule->getChargeProcessingFee(),
                'liable'                => $splitRule->getLiable()
            ];

            $rules[$key] = array_merge($rule, $this->getRuleValue($splitRule));
        }

        return $rules;
    }

    /**
     * @param PagarMe\Sdk\SplitRule\SplitRule $splitRule
     * @return array
     */
    private function getRuleValue($splitRule)
    {
        if (!is_null($splitRule->getAmount())) {
            return ['amount' => $splitRule->getAmount()];
        }

        return ['percentage' => $splitRule->getPercentage()];
    }
}
