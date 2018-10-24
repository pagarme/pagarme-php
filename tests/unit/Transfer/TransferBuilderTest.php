<?php

namespace PagarMe\SdkTest\Transfer;

class TransferGetTest extends \PHPUnit_Framework_TestCase
{
    use \PagarMe\Sdk\Transfer\TransferBuilder;
    /**
     * @test
     */
    public function mustTransferBeCreatedCorrectly()
    {
        // @codingStandardsIgnoreLine
        $payload = '{"object": "transfer", "id": 22180, "amount": 3612, "type": "credito_em_conta", "status": "pending_transfer", "source_type": "recipient", "source_id": "re_cix9cglnu018r9k6ec57ocmse", "target_type": "bank_account", "target_id": "17322882", "fee": 0, "funding_date": null, "funding_estimated_date": "2016-12-29T02:00:00.000Z", "transaction_id": null, "date_created": "2016-12-28T19:38:17.439Z", "bank_account": {"object": "bank_account", "id": 17322882, "bank_code": "237", "agencia": "1935", "agencia_dv": null, "conta": "060708", "conta_dv": "1", "type": "conta_corrente", "document_type": "cpf", "document_number": "20487713435", "legal_name": "Joao Silva", "charge_transfer_fees": true, "date_created": "2016-12-13T12:42:54.948Z"}}';

        $transfer = $this->buildTransfer(json_decode($payload));

        $this->assertInstanceOf('PagarMe\Sdk\Transfer\Transfer', $transfer);
        $this->assertInstanceOf(
            '\DateTime',
            $transfer->getFundingEstimatedDate()
        );
        $this->assertInstanceOf('\DateTime', $transfer->getDateCreated());
        $this->assertInstanceOf('\DateTime', $transfer->getFundingDate());
        $this->assertInstanceOf(
            'PagarMe\Sdk\BankAccount\BankAccount',
            $transfer->getBankAccount()
        );
    }

     /**
     * @test
     */
    public function mustCreateTransferWithoutBankAccount()
    {
        $payload = '{"object":"transfer","id":29827,"amount":176430,"type":"inter_recipient","status":"transferred","source_type":"recipient","source_id":"re_cix9cglnu018r9k6ec57ocmse","target_type":"recipient","target_id":"re_cix9cglnu018r9k6ec57ocmse","fee":0,"funding_date":"2018-05-10T20:47:42.283Z","funding_estimated_date":"2018-05-10T20:47:42.283Z","transaction_id":null,"date_created":"2018-05-10T20:47:42.284Z","metadata":{},"recipient":{"object":"recipient","id":"re_cix9cglnu018r9k6ec57ocmse","transfer_enabled":false,"last_transfer":null,"transfer_interval":"daily","transfer_day":0,"automatic_anticipation_enabled":true,"automatic_anticipation_type":"1025","automatic_anticipation_days":"[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31]","automatic_anticipation_1025_delay":30,"anticipatable_volume_percentage":100,"date_created":"2018-04-06T13:46:48.273Z","date_updated":"2018-04-06T13:46:48.565Z","bank_account":{"object":"bank_account","id":3162808,"bank_code":"033","agencia":"3242","agencia_dv":null,"conta":"01081871","conta_dv":"9","type":"conta_corrente","document_type":"cpf","document_number":"16741180745","legal_name":"AAMP Medicina Petropolis","charge_transfer_fees":true,"date_created":"2018-04-06T13:46:48.202Z"},"status":"active","status_reason":null,"postback_url":"","register_information":null,"metadata":null}}';

        $transfer = $this->buildTransfer(json_decode($payload));

        $this->assertInstanceOf(
            'PagarMe\Sdk\Transfer\Transfer', 
            $transfer
        );

        $this->assertInstanceOf(
            'PagarMe\Sdk\Recipient\Recipient', 
            $transfer->getRecipient()
        );

        $this->assertInstanceOf(
            'PagarMe\Sdk\BankAccount\BankAccount', 
            $transfer->getRecipient()->getBankAccount()
        );
    }
}
