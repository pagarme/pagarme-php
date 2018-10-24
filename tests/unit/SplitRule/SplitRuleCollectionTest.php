<?php

namespace PagarMe\SdkTest\SplitRule;

class SplitRuleCollectionTest extends \PHPUnit_Framework_TestCase
{
    use \PagarMe\Sdk\Transaction\TransactionBuilder;

    /**
     * @test
     */
    public function splitRuleCollectionMustBeCountable()
    {
        /** @var \PagarMe\Sdk\Transaction\AbstractTransaction $transaction */
        $transaction = $this->buildTransaction(
            json_decode(
                $this->creditCardTransactionCreateResponse()
            )
        );

        $this->assertInstanceOf(
            'PagarMe\Sdk\Transaction\CreditCardTransaction',
            $transaction
        );

        $this->assertInstanceOf(
            'PagarMe\Sdk\SplitRule\SplitRuleCollection',
            $transaction->getSplitRules()
        );

        $this->assertInstanceOf(
            'Countable',
            $transaction->getSplitRules()
        );

        $this->assertEquals(2, count($transaction->getSplitRules()));
    }

    public function creditCardTransactionCreateResponse()
    {
        // @codingStandardsIgnoreLine
        return '{"object":"transaction","status":"processing","refuse_reason":null,"status_reason":"acquirer","acquirer_response_code":null,"authorization_code":null,"soft_descriptor":"testeDeAPI","tid":null,"nsu":null,"date_created":"2015-02-25T21:54:56.000Z","date_updated":"2015-02-25T21:54:56.000Z","amount":310000,"installments":5,"id":184220,"cost":0,"postback_url":"http://requestb.in/pkt7pgpk","payment_method":"credit_card","antifraud_score":null,"boleto_url":null,"boleto_barcode":null,"boleto_expiration_date":null,"referer":"api_key","ip":"189.8.94.42","subscription_id":null,"phone":null,"address":null,"customer":null,"card":{"object":"card","id":"card_ci6l9fx8f0042rt16rtb477gj","date_created":"2015-02-25T21:54:56.000Z","date_updated":"2015-02-25T21:54:56.000Z","brand":"mastercard","holder_name":"Api Customer","first_digits":"548045","last_digits":"3123","fingerprint":"HSiLJan2nqwn","valid":null},"split_rules":[{"object":"split_rule","id":"sr_cixi05w5w04erhx6dllaght6m","recipient_id":"re_cixi05vxt04ephx6dxm1y0esy","charge_processing_fee":true,"charge_remainder":false,"liable":true,"percentage":49,"amount":null,"date_created":"2017-01-03T21:03:56.948Z","date_updated":"2017-01-03T21:03:56.948Z"},{"object":"split_rule","id":"sr_cixi05w5v04eqhx6d4ala4v4b","recipient_id":"re_cixi05vt4053fmm6etx9e7h9f","charge_processing_fee":true,"charge_remainder":true,"liable":true,"percentage":51,"amount":null,"date_created":"2017-01-03T21:03:56.947Z","date_updated":"2017-01-03T21:03:56.947Z"}],"metadata":{"idProduto":"13933139"}}';
    }
}
