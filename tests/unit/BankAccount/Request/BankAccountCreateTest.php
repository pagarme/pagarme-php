<?php

namespace PagarMe\SdkTest\BankAccount\Request;

use PagarMe\Sdk\BankAccount\Request\BankAccountCreate;
use PagarMe\Sdk\RequestInterface;

class BankAccountCreateTest extends \PHPUnit_Framework_TestCase
{
    const PATH            = 'bank_accounts';

    public function accountDataProvider()
    {
        return [
            [
                001,
                1977,
                1935,
                1,
                67178880244,
                'Maria Silva',
                1,
                null
            ],
            [
                033,
                1986,
                010203,
                2,
                75232346660,
                'Carlos Silva',
                null,
                'conta_corrente
            '],
            [
                104,
                1991,
                10001,
                3,
                13067245890,
                'Cesar Silva',
                3,
                'conta_poupanca
            '],
            [
                237,
                2006,
                80486,
                4,
                26260865686,
                'Luiza Silva',
                null,
                'conta_corrente_conjunta
            '],
            [
                341,
                2007,
                233500,
                5,
                11663782687,
                'Joao Silva',
                null,
                'conta_poupanca_conjunta
            ']
        ];
    }

    /**
     * @dataProvider accountDataProvider
     * @test
     */
    public function mustContentBeCorrect(
        $bankCode,
        $agencia,
        $conta,
        $contaDv,
        $documentNumber,
        $legalName,
        $agenciaDv,
        $type
    ) {
        $bankAccountCreate = new BankAccountCreate(
            $bankCode,
            $agencia,
            $conta,
            $contaDv,
            $documentNumber,
            $legalName,
            $agenciaDv,
            $type
        );

        $this->assertEquals(RequestInterface::HTTP_POST, $bankAccountCreate->getMethod());
        $this->assertEquals(self::PATH, $bankAccountCreate->getPath());
        $this->assertEquals(
            [
                'bank_code'       => $bankCode,
                'agencia'         => $agencia,
                'conta'           => $conta,
                'conta_dv'        => $contaDv,
                'document_number' => $documentNumber,
                'legal_name'      => $legalName,
                'agencia_dv'      => $agenciaDv,
                'type'            => $type
            ],
            $bankAccountCreate->getPayload()
        );
    }
}
