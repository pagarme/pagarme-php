<?php

namespace PagarMe\SdkTest\Transaction\Request;

use PagarMe\Sdk\Transaction\Request\TransactionCapture;
use PagarMe\Sdk\Transaction\CreditCardTransaction;
use PagarMe\Sdk\RequestInterface;
use PHPUnit\Framework\TestCase;

class TransactionCaptureTest extends TestCase
{
    const PATH   = 'transactions/%s/capture';

    private $defaultMetadata = ['foo' => 'bar'];

    public function transactionIdProvider()
    {
        return [
            [555, null , []],
            [273690, 500 , ['amount'   => 500]],
            [888888, 76500 , ['amount' => 76500]]
        ];
    }

    /**
     * @dataProvider transactionIdProvider
     * @test
     */
    public function mustPayloadBeCorrectWithTransactionId(
        $transactionId,
        $amount,
        $payload
    ) {
        $transaction = $this->getAbstractTransactionMock();

        $transaction->method('getId')->willReturn($transactionId);

        $transactionCreate = new TransactionCapture($transaction, $amount);

        $this->assertEquals(
            $payload,
            $transactionCreate->getPayload()
        );

        $this->assertEquals(
            sprintf(self::PATH, $transactionId),
            $transactionCreate->getPath()
        );

        $this->assertEquals(RequestInterface::HTTP_POST, $transactionCreate->getMethod());
    }

    public function tokenProvider()
    {
        return [
            [uniqid('token'), null , []],
            [uniqid('token'), 500 , ['amount'   => 500]],
            [uniqid('token'), 76500 , ['amount' => 76500]]
        ];
    }

    /**
     * @dataProvider tokenProvider
     * @test
     */
    public function mustPayloadBeCorrectWithToken($token, $amount, $payload)
    {
        $transaction = $this->getAbstractTransactionMock();

        $transaction->method('getToken')->willReturn($token);

        $transactionCreate = new TransactionCapture($transaction, $amount);

        $this->assertEquals(
            $payload,
            $transactionCreate->getPayload()
        );

        $this->assertEquals(
            sprintf(self::PATH, $token),
            $transactionCreate->getPath()
        );

        $this->assertEquals(RequestInterface::HTTP_POST, $transactionCreate->getMethod());
    }

    /**
     * @test
     */
    public function mustUseTransactionIdInsteadOfToken()
    {
        $transactionId = 123456;
        $transaction = $this->getAbstractTransactionMock();

        $transaction->method('getToken')->willReturn('abcdef');
        $transaction->method('getId')->willReturn($transactionId);

        $transactionCreate = new TransactionCapture($transaction, null);

        $this->assertEquals(
            sprintf(self::PATH, $transactionId),
            $transactionCreate->getPath()
        );
    }

    protected function getAbstractTransactionMock()
    {
        return $this->getMockBuilder(
            'PagarMe\Sdk\Transaction\AbstractTransaction'
        )->disableOriginalConstructor()
        ->getMock();
    }

    public function transactionMetadataProvider()
    {
        return [
            [null, $this->defaultMetadata, ['metadata' => $this->defaultMetadata]],
            [500 , $this->defaultMetadata, ['amount' => 500, 'metadata' => $this->defaultMetadata]],
            [76500, $this->defaultMetadata, ['amount' => 76500, 'metadata' => $this->defaultMetadata]]
        ];
    }

    /**
     * @test
     * @dataProvider transactionMetadataProvider
     */
    public function payloadMustBeEqualWhenProvidingMetadataAtTheCaptureStep(
        $amount,
        $metadata,
        $expectedPayload
    ) {
        $transactionCreate = new TransactionCapture(
            $this->getAbstractTransactionMock(),
            $amount,
            $metadata
        );

        $this->assertEquals(
            $expectedPayload,
            $transactionCreate->getPayload()
        );
    }
}
