<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Transaction\Transaction;
use PagarMe\Sdk\SplitRule\SplitRuleCollection;

class TransactionCreate implements Request
{
    protected $transaction;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

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
            ]
        ];

        if ($this->transaction->getSplitRules() instanceof SplitRuleCollection) {
            $transactionData['split_rules'] = $this->getSplitRulesInfo(
                $this->transaction->getSplitRules()
            );
        }

        return $transactionData;
    }

    public function getPath()
    {
        return 'transactions';
    }

    public function getMethod()
    {
        return 'POST';
    }

    private function getSplitRulesInfo(SplitRuleCollection $splitRules)
    {
        $rules = [];

        foreach ($splitRules as $key => $splitRule) {
            $rules[$key] = [
                'recipient_id'          => $splitRule->getRecipient()->getId(),
                'charge_processing_fee' => $splitRule->getChargeProcessingFee(),
                'liable'                => $splitRule->getLiable(),
                'amount'                => $splitRule->getAmount(),
                'percentage'            => $splitRule->getPercentage()
            ];
        }

        return $rules;
    }
}
