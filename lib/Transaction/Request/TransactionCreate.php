<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Transaction\Transaction;

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

        return [
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
    }

    public function getPath()
    {
        return 'transactions';
    }

    public function getMethod()
    {
        return 'POST';
    }

    /**
     * @return string
     */
    public function getAuthenticationMethod()
    {
        return self::API_KEY;
    }
}
