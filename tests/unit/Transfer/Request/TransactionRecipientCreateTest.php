<?php

namespace PagarMe\SdkTest\Transfer\Request;

use PagarMe\Sdk\Transfer\Request\TransactionRecipientCreate;

class TransactionRecipientCreateTest extends \PHPUnit_Framework_TestCase
{
    const METHOD       = 'POST';
    const PATH         = 'transfers';
    const RECIPIENT_ID = 123;
    const AMOUNT       = 1337;

    /**
     * @test
     **/
    public function mustPayloadBeCorrect()
    {
        $recipientMock = $this->getMockBuilder('PagarMe\Sdk\Recipient\Recipient')
            ->disableOriginalConstructor()
            ->getMock();

        $recipientMock->method('getId')->willReturn(self::RECIPIENT_ID);

        $transactionRecipientCreate = new TransactionRecipientCreate(
            self::AMOUNT,
            $recipientMock
        );

        $this->assertEquals(
            [
                'amount'       => self::AMOUNT,
                'recipient_id' => self::RECIPIENT_ID
            ],
            $transactionRecipientCreate->getPayload()
        );
    }

    /**
     * @test
     **/
    public function mustMethodBeCorrect()
    {
        $recipientMock = $this->getMockBuilder('PagarMe\Sdk\Recipient\Recipient')
            ->disableOriginalConstructor()
            ->getMock();


        $transactionRecipientCreate = new TransactionRecipientCreate(
            self::AMOUNT,
            $recipientMock
        );

        $this->assertEquals(self::METHOD, $transactionRecipientCreate->getMethod());
    }

    /**
     * @test
     **/
    public function mustPathBeCorrect()
    {
        $recipientMock = $this->getMockBuilder('PagarMe\Sdk\Recipient\Recipient')
            ->disableOriginalConstructor()
            ->getMock();

        $transactionRecipientCreate = new TransactionRecipientCreate(
            self::AMOUNT,
            $recipientMock
        );

        $this->assertEquals(self::PATH, $transactionRecipientCreate->getPath());
    }
}
