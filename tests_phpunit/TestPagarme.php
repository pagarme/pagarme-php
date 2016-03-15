<?php

use PHPUnit_Framework_TestCase as PHPUnit;

use Pagarme\Transaction\Transaction,
    Pagarme\Card\Card,
    Pagarme\Core as PagarMe,
    Pagarme\Plan,
    Pagarme\Subscription,
    Pagarme\BankAccount,
    Pagarme\Recipient,
    Pagarme\Set as PagarmeSet,
    Pagarme\Object as PagarmeObject;

class TestPagarme extends PHPUnit
{
    public function authorizeFromEnv()
    {
        $apiKey = getenv('PAGARME_API_KEY');
        if (! $apiKey)
            $apiKey = "ak_test_Rw4JR98FmYST2ngEHtMvVf5QJW7Eoo";
        PagarMe::setApiKey($apiKey);
    }

    public function testCreateTransaction(array $attributes = array())
    {
        $this->authorizeFromEnv();

        return new Transaction(
            $attributes +
            array(
                "amount"                => '1000',
                "card_number"           => "4901720080344448",
                "card_holder_name"      => "Jose da Silva",
                "card_expiration_month" => '12',
                "card_expiration_year"  => '15',
                "card_cvv"              => "123",
            ));
    }

    public function testCreateCustomer(array $attributes = array())
    {
        $customer = array(
            'name'            => "Jose da Silva",
            'document_number' => "36433809847",
            'email'           => "customer@pagar.me",
            'address'         => array(
                'street'        => "Av Faria Lima",
                'neighborhood'  => 'Jardim Europa',
                'zipcode'       => '01452000',
                'street_number' => '296',
                'complementary' => '8 andar'
            ),
            'phone'           => array(
                'ddd'    => '12',
                'number' => '999999999',
            ),
            'sex'             => 'M',
            'born_at'         => '1995-10-11'
        );

        return $customer;
    }

    public function testCreateCard(array $attributes = array())
    {
        $this->authorizeFromEnv();

        return new Card(array(
            'card_number'           => '4111111111111111',
            'card_holder_name'      => 'Jose da Silva',
            'card_expiration_month' => '10',
            'card_expiration_year'  => '22',
            'card_cvv'              => '123',
        ));
    }

    public function createTestTransactionWithCustomer(array $attributes = array())
    {
        $this->authorizeFromEnv();
        $transaction           = self::createTestTransaction();
        $transaction->customer = self::createTestCustomer();

        return $transaction;
    }

    public function testCreatePlan(array $attributes = array())
    {
        $this->authorizeFromEnv();

        return new Plan($attributes +
            array(
                'amount'     => 1000,
                'days'       => '30',
                'name'       => "Plano Silver",
                'trial_days' => '2'
            )
        );
    }

    public function testCreateSubscription(array $attributes = array())
    {
        $this->authorizeFromEnv();

        return new Subscription($attributes + array(
                "card_number"           => "4901720080344448",
                "card_holder_name"      => "Jose da Silva",
                "card_expiration_month" => 12,
                "card_expiration_year"  => 15,
                "card_cvv"              => "123",
                'customer'              => array(
                    'email' => 'customer@pagar.me'
                )
            ));
    }

    public function testCreateBankAccount(array $attributes = array())
    {
        $this->authorizeFromEnv();

        return new BankAccount(array(
            "bank_code"       => "341",
            "agencia"         => "0932",
            "agencia_dv"      => "5",
            "conta"           => "58054",
            "conta_dv"        => "1",
            "document_number" => "26268738888",
            "legal_name"      => "API BANK ACCOUNT"
        ));
    }

    public function testCreateRecipient(array $attributes = array())
    {
        $this->authorizeFromEnv();

        return new Recipient(array(
            "transfer_interval"               => "weekly",
            "transfer_day"                    => 5,
            "transfer_enabled"                => true,
            "automatic_anticipation_enabled"  => true,
            "anticipatable_volume_percentage" => 85,
            "bank_account"                    => array(
                "bank_code"       => "341",
                "agencia"         => "0932",
                "agencia_dv"      => "5",
                "conta"           => "58054",
                "conta_dv"        => "1",
                "document_number" => "26268738888",
                "legal_name"      => "API BANK ACCOUNT",
            )
        ));
    }

    public function testCreateSet()
    {
        return new PagarmeSet(array('key', 'value', 'key', 'value', 'abc', 'bcd', 'kkkk'));
    }

    public function createPagarMeObject()
    {
        $response = array(
            "status"           => "paid",
            "object"           => 'transaction',
            "refuse_reason"    => null,
            "date_created"     => "2013-09-26T03:19:36.000Z",
            "amount"           => 1590,
            "installments"     => 1,
            "id"               => 1379,
            "card_holder_name" => "Jose da Silva",
            "card_last_digits" => "4448",
            "card_brand"       => "visa",
            "postback_url"     => null,
            "payment_method"   => "credit_card",
            "customer"         => array(
                'object'          => 'customer',
                "document_number" => "51472745531",
                'address'         => array(
                    'object' => "address",
                    'street' => 'asdas'
                )
            )
        );

        return PagarmeObject::build($response, "Pagarme\\Transaction\\Transaction");
    }

}
