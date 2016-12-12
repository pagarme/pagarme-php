<?php

namespace Pagarme\SdkTests\Transaction;

use PagarMe\Sdk\Transaction\TransactionHandler;
use PagarMe\Sdk\Transaction\AbstractTransaction;

class TransactionHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @test
    **/
    public function mustCreateCreditCardTransaction()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->method('send')
            ->willReturn(json_decode($this->creditCardTransactionCreateResponse()));

        $handler = new TransactionHandler($clientMock);

        $card = $this->getMockBuilder('PagarMe\Sdk\Card\Card')
            ->disableOriginalConstructor()
            ->getMock();

        $customer = $this->getMockBuilder('PagarMe\Sdk\Customer\Customer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertInstanceOf(
            'PagarMe\Sdk\Transaction\CreditCardTransaction',
            $handler->creditCardTransaction(
                310000,
                $card,
                $customer
            )
        );
    }

    /**
     * @test
    **/
    public function mustCreateBoletoTransaction()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->method('send')
            ->willReturn(json_decode($this->boletoTransactionCreateResponse()));

        $handler = new TransactionHandler($clientMock);

        $customer = $this->getMockBuilder('PagarMe\Sdk\Customer\Customer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertInstanceOf(
            'PagarMe\Sdk\Transaction\BoletoTransaction',
            $handler->boletoTransaction(
                310000,
                $customer,
                'example.com/postback'
            )
        );
    }

    /**
     * @test
    **/
    public function mustReturnBoletoTransaction()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->method('send')
            ->willReturn(json_decode($this->boletoTransactionCreateResponse()));

        $handler = new TransactionHandler($clientMock);

        $customer = $this->getMockBuilder('PagarMe\Sdk\Customer\Customer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertInstanceOf(
            'PagarMe\Sdk\Transaction\BoletoTransaction',
            $handler->get(12345)
        );
    }

    /**
     * @test
    **/
    public function mustReturnCreditCardTransaction()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->method('send')
            ->willReturn(json_decode($this->creditCardTransactionCreateResponse()));

        $handler = new TransactionHandler($clientMock);

        $customer = $this->getMockBuilder('PagarMe\Sdk\Customer\Customer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertInstanceOf(
            'PagarMe\Sdk\Transaction\CreditCardTransaction',
            $handler->get(12345)
        );
    }

    /**
     * @test
    **/
    public function mustReturnRefundedCreditCardTransaction()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->method('send')
            ->willReturn(json_decode($this->creditCardTransactionRefundResponse()));

        $handler = new TransactionHandler($clientMock);

        $creditCardTransactionMock = $this->getMockBuilder('PagarMe\Sdk\Transaction\CreditCardTransaction')
            ->disableOriginalConstructor()
            ->getMock();

        $creditCardTransactionMock->method('getId')
            ->willReturn(rand(1000, 2000));

        $transaction = $handler->creditCardRefund($creditCardTransactionMock);

        $this->assertTrue($transaction->isRefunded());
    }

    /**
     * @test
    **/
    public function mustReturnRefundedBoletoTransaction()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->method('send')
            ->willReturn(json_decode($this->boletoTransactionRefundResponse()));

        $handler = new TransactionHandler($clientMock);

        $boletoTransactionMock = $this->getMockBuilder('PagarMe\Sdk\Transaction\BoletoTransaction')
            ->disableOriginalConstructor()
            ->getMock();

        $bankAccountMock = $this->getMockBuilder('PagarMe\Sdk\BankAccount\BankAccount')
            ->disableOriginalConstructor()
            ->getMock();

        $boletoTransactionMock->method('getId')
            ->willReturn(rand(1000, 2000));

        $transaction = $handler->boletoRefund(
            $boletoTransactionMock,
            $bankAccountMock
        );

        $this->assertTrue($transaction->isPendingRefund());
    }

    /**
     * @test
     * @expectedException PagarMe\Sdk\Transaction\UnsupportedTransaction
    **/
    public function mustThrowUnsupportedTransaction()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->method('send')
            ->willReturn(json_decode('{"object":"transaction","payment_method":"other"}'));

        $handler = new TransactionHandler($clientMock);

        $customer = $this->getMockBuilder('PagarMe\Sdk\Customer\Customer')
            ->disableOriginalConstructor()
            ->getMock();

        $handler->get(12345);
    }

    /**
     * @test
    **/
    public function mustReturnArrayOfTransaction()
    {
        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();
        $clientMock->method('send')
            ->willReturn(json_decode($this->transactionListResponse()));

        $handler = new TransactionHandler($clientMock);

        $this->assertContainsOnly(
            'PagarMe\Sdk\Transaction\AbstractTransaction',
            $handler->getList()
        );
    }

    public function creditCardTransactionCreateResponse()
    {
        return '{"object":"transaction","status":"processing","refuse_reason":null,"status_reason":"acquirer","acquirer_response_code":null,"authorization_code":null,"soft_descriptor":"testeDeAPI","tid":null,"nsu":null,"date_created":"2015-02-25T21:54:56.000Z","date_updated":"2015-02-25T21:54:56.000Z","amount":310000,"installments":5,"id":184220,"cost":0,"postback_url":"http://requestb.in/pkt7pgpk","payment_method":"credit_card","antifraud_score":null,"boleto_url":null,"boleto_barcode":null,"boleto_expiration_date":null,"referer":"api_key","ip":"189.8.94.42","subscription_id":null,"phone":null,"address":null,"customer":null,"card":{"object":"card","id":"card_ci6l9fx8f0042rt16rtb477gj","date_created":"2015-02-25T21:54:56.000Z","date_updated":"2015-02-25T21:54:56.000Z","brand":"mastercard","holder_name":"Api Customer","first_digits":"548045","last_digits":"3123","fingerprint":"HSiLJan2nqwn","valid":null},"metadata":{"idProduto":"13933139"}}';
    }

    public function creditCardTransactionRefundResponse()
    {
        return '{"object":"transaction","status":"refunded","refuse_reason":null,"status_reason":"acquirer","acquirer_response_code":"00","acquirer_name":"pagarme","authorization_code":"418519","soft_descriptor":null,"tid":742083,"nsu":742083,"date_created":"2016-09-29T15:36:08.020Z","date_updated":"2016-09-29T17:48:34.600Z","amount":10000,"authorized_amount":10000,"paid_amount":10000,"refunded_amount":10000,"installments":1,"id":742083,"cost":0,"card_holder_name":"João Silva","card_last_digits":"8357","card_first_digits":"491668","card_brand":"visa","postback_url":null,"payment_method":"credit_card","capture_method":"ecommerce","antifraud_score":null,"boleto_url":null,"boleto_barcode":null,"boleto_expiration_date":null,"referer":"api_key","ip":"187.11.121.49","subscription_id":null,"phone":{"object":"phone","ddi":"55","ddd":"11","number":"999887766","id":43754},"address":{"object":"address","street":"rua qualquer","complementary":"apto","street_number":"13","neighborhood":"pinheiros","city":"sao paulo","state":"SP","zipcode":"05444040","country":"Brasil","id":45774},"customer":{"object":"customer","document_number":"18152564000105","document_type":"cnpj","name":"nome do cliente","email":"user57ed355d4340c@email.com","born_at":"1970-01-01T03:38:41.988Z","gender":"M","date_created":"2016-09-13T18:04:17.200Z","id":93076},"card":{"object":"card","id":"card_citn4cmtp00u2dn6e82m7ovky","date_created":"2016-09-28T16:21:11.437Z","date_updated":"2016-09-28T16:21:11.595Z","brand":"visa","holder_name":"João Silva","first_digits":"491668","last_digits":"8357","country":"US","fingerprint":"rv00k8EENnuX","valid":true,"expiration_date":"0723"},"split_rules":null,"metadata":{},"antifraud_metadata":{}}';
    }

    public function boletoTransactionRefundResponse()
    {
        return '{"object":"transaction","status":"pending_refund","refuse_reason":null,"status_reason":"acquirer","acquirer_response_code":null,"acquirer_name":"pagarme","authorization_code":null,"soft_descriptor":null,"tid":748397,"nsu":748397,"date_created":"2016-10-03T15:45:00.395Z","date_updated":"2016-10-03T15:47:53.281Z","amount":3100,"authorized_amount":3100,"paid_amount":3100,"refunded_amount":0,"installments":1,"id":748397,"cost":380,"card_holder_name":null,"card_last_digits":null,"card_first_digits":null,"card_brand":null,"postback_url":"http://requestb.in/pkt7pgpk","payment_method":"boleto","capture_method":"ecommerce","antifraud_score":null,"boleto_url":"https://pagar.me","boleto_barcode":"1234 5678","boleto_expiration_date":"2016-10-10T03:00:00.392Z","referer":"api_key","ip":"187.11.121.49","subscription_id":null,"phone":null,"address":null,"customer":null,"card":null,"split_rules":null,"metadata":{"idProduto":"13933139"},"antifraud_metadata":{}}';
    }

    public function transactionListResponse()
    {
        return sprintf(
            '[%s,%s]',
            $this->creditCardTransactionCreateResponse(),
            $this->boletoTransactionCreateResponse()
        );
    }

    public function boletoTransactionCreateResponse()
    {
        return '{"object":"transaction","status":"waiting_payment","refuse_reason":null,"status_reason":"acquirer","acquirer_response_code":null,"acquirer_name":"pagarme","authorization_code":null,"soft_descriptor":null,"tid":733692,"nsu":733692,"date_created":"2016-09-26T19:14:35.119Z","date_updated":"2016-09-26T19:14:35.281Z","amount":3100,"authorized_amount":3100,"paid_amount":0,"refunded_amount":0,"installments":1,"id":733692,"cost":0,"card_holder_name":null,"card_last_digits":null,"card_first_digits":null,"card_brand":null,"postback_url":null,"payment_method":"boleto","capture_method":"ecommerce","antifraud_score":null,"boleto_url":"https://pagar.me","boleto_barcode":"1234 5678","boleto_expiration_date":"2016-10-03T03:00:00.117Z","referer":"api_key","ip":"187.11.121.49","subscription_id":null,"phone":null,"address":null,"customer":null,"card":null,"split_rules":null,"metadata":{},"antifraud_metadata":{}}';
    }
}
