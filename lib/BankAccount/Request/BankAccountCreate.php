<?php

namespace PagarMe\Sdk\BankAccount\Request;

use PagarMe\Sdk\Request;

class BankAccountCreate implements Request
{
    /**
     * @var int
     */
    private $bankCode;

    /**
     * @var int
     */
    private $agencia;

    /**
     * @var int
     */
    private $agenciaDv;

    /**
     * @var int
     */
    private $conta;

    /**
     * @var int
     */
    private $contaDv;

    /**
     * @var int
     */
    private $documentNumber;

    /**
     * @var string
     */
    private $legalName;

    /**
     * @param int $bankCode
     * @param int $agencia
     * @param int $conta
     * @param int $contaDv
     * @param int $documentNumber
     * @param int $legalName
     * @param string $agenciaDv
     */
    public function __construct(
        $bankCode,
        $agencia,
        $conta,
        $contaDv,
        $documentNumber,
        $legalName,
        $agenciaDv
    ) {
        $this->bankCode       = $bankCode;
        $this->agencia        = $agencia;
        $this->conta          = $conta;
        $this->contaDv        = $contaDv;
        $this->documentNumber = $documentNumber;
        $this->legalName      = $legalName;
        $this->agenciaDv      = $agenciaDv;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [
            'bank_code'       => $this->bankCode,
            'agencia'         => $this->agencia,
            'conta'           => $this->conta,
            'conta_dv'        => $this->contaDv,
            'document_number' => $this->documentNumber,
            'legal_name'      => $this->legalName,
            'agencia_dv'      => $this->agenciaDv
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'bank_accounts';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_POST;
    }
}
