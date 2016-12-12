<?php

namespace PagarMe\SdkTest\Transaction\Request;

use PagarMe\Sdk\Transaction\Request\BoletoTransactionRefund;
use PagarMe\Sdk\Transaction\BoletoTransaction;

class BoletoTransactionRefundTest extends \PHPUnit_Framework_TestCase
{
    const METHOD          = 'POST';
    const PATH            = 'transactions/1337/refund';
    const TRANSACTION_ID  = 1337;
    const BANKACCOUNT_ID  = 12345;
    const AMOUNT          = 500;
    const BANK_CODE       = 237;
    const AGENCIA         = 1382;
    const AGENCIA_DV      = 0;
    const CONTA           = 13399;
    const CONTA_DV        = 1;
    const DOCUMENT_NUMBER = 69717356840;
    const LEGAL_NAME      = 'João Silva';

    /**
     * @test
    **/
    public function payloadMustContainBankAccountId()
    {
        $bankAccountMock = $this->getMockBuilder('PagarMe\Sdk\BankAccount\BankAccount')
            ->disableOriginalConstructor()
            ->getMock();
        $bankAccountMock->method('getId')
            ->willReturn(self::BANKACCOUNT_ID);

        $transactionCreate = new BoletoTransactionRefund(
            $this->getTransactionMock(),
            $bankAccountMock,
            self::AMOUNT
        );

        $this->assertEquals(
            [
                'amount'          => self::AMOUNT,
                'bank_account_id' => self::BANKACCOUNT_ID
            ],
            $transactionCreate->getPayload()
        );

        $this->assertEquals(
            sprintf(self::PATH, self::TRANSACTION_ID),
            $transactionCreate->getPath()
        );

        $this->assertEquals(self::METHOD, $transactionCreate->getMethod());
    }

    /**
     * @test
    **/
    public function payloadMustContainBankData()
    {
        $bankAccountMock = $this->getMockBuilder('PagarMe\Sdk\BankAccount\BankAccount')
            ->disableOriginalConstructor()
            ->getMock();

        $bankAccountMock->method('getBankCode')->willReturn(self::BANK_CODE);
        $bankAccountMock->method('getAgencia')->willReturn(self::AGENCIA);
        $bankAccountMock->method('getAgenciaDv')->willReturn(self::AGENCIA_DV);
        $bankAccountMock->method('getConta')->willReturn(self::CONTA);
        $bankAccountMock->method('getContaDv')->willReturn(self::CONTA_DV);
        $bankAccountMock->method('getDocumentNumber')->willReturn(self::DOCUMENT_NUMBER);
        $bankAccountMock->method('getLegalName')->willReturn(self::LEGAL_NAME);

        $transactionCreate = new BoletoTransactionRefund(
            $this->getTransactionMock(),
            $bankAccountMock,
            self::AMOUNT
        );

        $this->assertEquals(
            [
                'amount'          => self::AMOUNT,
                'bank_code'       => self::BANK_CODE,
                'agencia'         => self::AGENCIA,
                'agencia_dv'      => self::AGENCIA_DV,
                'conta'           => self::CONTA,
                'conta_dv'        => self::CONTA_DV,
                'document_number' => self::DOCUMENT_NUMBER,
                'legal_name'      => self::LEGAL_NAME,
            ],
            $transactionCreate->getPayload()
        );

        $this->assertEquals(
            sprintf(self::PATH, self::TRANSACTION_ID),
            $transactionCreate->getPath()
        );

        $this->assertEquals(self::METHOD, $transactionCreate->getMethod());
    }

    private function getTransactionMock()
    {
        $transactionMock = $this->getMockBuilder('PagarMe\Sdk\Transaction\BoletoTransaction')
            ->disableOriginalConstructor()
            ->getMock();

        $transactionMock->method('getId')->willReturn(self::TRANSACTION_ID);

        return $transactionMock;
    }
}
