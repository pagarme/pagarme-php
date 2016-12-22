<?php

namespace Pagarme\SdkTests\Recipient;

use PagarMe\Sdk\Recipient\RecipientHandler;
use PagarMe\Sdk\Recipient\Recipient;

class RecipientHandlerTest extends \PHPUnit_Framework_TestCase
{
    const TRANSFER_INTERVAL = 'weekly';
    const TRANSFER_DAY      = '5';
    const TRANSFER_ENABLED  = true;

    /**
     * @test
    **/
    public function mustReturnCreatedRecipient()
    {
        $bankAccountMock = $this->getMockBuilder('PagarMe\Sdk\BankAccount\BankAccount')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->method('send')
            ->willReturn(json_decode('{"object":"recipient","id":"re_ci9bucss300h1zt6dvywufeqc","bank_account":{"object":"bank_account","id":4841,"bank_code":"341","agencia":"0932","agencia_dv":"5","conta":"58054","conta_dv":"1","document_type":"cpf","document_number":"26268738888","legal_name":"API BANK ACCOUNT","charge_transfer_fees":false,"date_created":"2015-03-19T15:40:51.000Z"},"transfer_enabled":true,"last_transfer":null,"transfer_interval":"weekly","transfer_day":5,"automatic_anticipation_enabled":true,"anticipatable_volume_percentage":85,"date_created":"2015-05-05T21:41:48.000Z","date_updated":"2015-05-05T21:41:48.000Z"}'));

        $handler = new RecipientHandler($clientMock);

        $recipient = $handler->create(
            $bankAccountMock,
            self::TRANSFER_INTERVAL,
            self::TRANSFER_DAY,
            self::TRANSFER_ENABLED
        );

        $this->assertInstanceOf(
            'PagarMe\Sdk\Recipient\Recipient',
            $recipient
        );
    }

    /**
     * @test
    **/
    public function mustReturnAnArrayOfRecipients()
    {
        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->method('send')
            ->willReturn(json_decode($this->recipientsListResponse()));

        $handler = new RecipientHandler($clientMock);
        $recipients = $handler->getList();

        $this->assertContainsOnly(
            'PagarMe\Sdk\Recipient\Recipient',
            $recipients
        );
    }

    /**
     * @test
    **/
    public function mustReturnAnRecipient()
    {
        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->method('send')
            ->willReturn(json_decode($this->recipientsGetResponse()));

        $handler = new RecipientHandler($clientMock);
        $recipient = $handler->get('re_x1y2z3');

        $this->assertInstanceOf(
            'PagarMe\Sdk\Recipient\Recipient',
            $recipient
        );
    }

    /**
     * @test
    **/
    public function mustReturnBalance()
    {
        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $recipientMock =  $this->getMockBuilder('PagarMe\Sdk\Recipient\Recipient')
            ->disableOriginalConstructor()
            ->getMock();

        $recipientMock->method('getId')->willReturn('re_x1y2z3');

        $clientMock->method('send')
            ->willReturn(json_decode('{"object": "balance", "waiting_funds": {"amount": 0 }, "available": {"amount": 3019898 }, "transferred": {"amount": 3163500 }}'));

        $handler = new RecipientHandler($clientMock);

        $balance = $handler->balance($recipientMock);

        $this->assertInstanceOf(
            'PagarMe\Sdk\Balance\Balance',
            $balance
        );
    }

    /**
     * @test
    **/
    public function mustReturnOperation()
    {
        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $recipientMock =  $this->getMockBuilder('PagarMe\Sdk\Recipient\Recipient')
            ->disableOriginalConstructor()
            ->getMock();

        $recipientMock->method('getId')->willReturn('re_x1y2z3');

        $clientMock->method('send')
            ->willReturn(json_decode('{"object": "balance_operation", "id": 4861, "status": "available", "balance_amount": 3019898, "balance_old_amount": 2920013, "movement_type": "payable", "amount": 100000, "fee": 115, "date_created": "2015-03-06T21:00:31.000Z", "movement_object": {"object": "payable", "id": 1297, "status": "paid", "amount": 100000, "fee": 115, "installment": 1, "transaction_id": 185537, "payment_date": "2015-03-06T03:00:00.000Z", "date_created": "2015-03-06T21:00:31.000Z"}}'));

        $handler = new RecipientHandler($clientMock);

        $operation = $handler->balanceOperation($recipientMock, 3861);

        $this->assertInstanceOf(
            'PagarMe\Sdk\BalanceOperations\Operation',
            $operation
        );
    }

    /**
     * @test
    **/
    public function mustReturnArrayOfOperations()
    {
        $clientMock =  $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $recipientMock =  $this->getMockBuilder('PagarMe\Sdk\Recipient\Recipient')
            ->disableOriginalConstructor()
            ->getMock();

        $recipientMock->method('getId')->willReturn('re_x1y2z3');

        $clientMock->method('send')
            ->willReturn(json_decode('[{"object":"balance_operation","id":4861,"status":"available","balance_amount":3019898,"balance_old_amount":2920013,"movement_type":"payable","amount":100000,"fee":115,"date_created":"2015-03-06T21:00:31.000Z","movement_object":{"object":"payable","id":1297,"status":"paid","amount":100000,"fee":115,"installment":1,"transaction_id":185537,"payment_date":"2015-03-06T03:00:00.000Z","date_created":"2015-03-06T21:00:31.000Z"}},{"object":"balance_operation","id":4852,"status":"available","balance_amount":2920013,"balance_old_amount":2910128,"movement_type":"payable","amount":10000,"fee":115,"date_created":"2015-03-06T18:44:42.000Z","movement_object":{"object":"payable","id":1294,"status":"paid","amount":10000,"fee":115,"installment":1,"transaction_id":185507,"payment_date":"2015-03-06T03:00:00.000Z","date_created":"2015-03-06T18:44:42.000Z"}},{"object":"balance_operation","id":4840,"status":"available","balance_amount":2910128,"balance_old_amount":2880243,"movement_type":"payable","amount":30000,"fee":115,"date_created":"2015-03-05T19:32:36.000Z","movement_object":{"object":"payable","id":1290,"status":"paid","amount":30000,"fee":115,"installment":1,"transaction_id":185273,"payment_date":"2015-03-05T03:00:00.000Z","date_created":"2015-03-05T19:32:35.000Z"}}]'));

        $handler = new RecipientHandler($clientMock);

        $operations = $handler->balanceOperations($recipientMock);

        $this->assertGreaterThan(2, count($operations));

        $this->assertContainsOnlyInstancesOf(
            'PagarMe\Sdk\BalanceOperations\Operation',
            $operations
        );
    }

    public function recipientsListResponse()
    {
        $response = $this->recipientsGetResponse();
        return sprintf('[%s,%s]', $response, $response);
    }

    public function recipientsGetResponse()
    {
        return '{"object":"recipient","id":"re_x1y2z3","transfer_enabled":true,"last_transfer":null,"transfer_interval":"weekly","transfer_day":5,"automatic_anticipation_enabled":true,"anticipatable_volume_percentage":85,"date_created":"2016-10-17T16:10:11.537Z","date_updated":"2016-10-17T16:10:11.537Z","bank_account":{"object":"bank_account","id":15671961,"bank_code":"000","agencia":"0000","agencia_dv":null,"conta":"00000","conta_dv":"0","document_type":"cnpj","document_number":"00000000000000","legal_name":"CONTA BANCARIA DE TESTES","charge_transfer_fees":true,"date_created":"2016-08-10T10:55:23.545Z"}}';
    }
}
