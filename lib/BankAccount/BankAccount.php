<?php

namespace PagarMe\Sdk\BankAccount;

class BankAccount
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var int
     */
    private $id;

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
    private $documentType;

    /**
     * @var string
     */
    private $legalName;

    /**
     * @var string
     */
    private $dateCreated;

    /**
     * @param array $arrayData
     */
    public function __construct($arrayData)
    {
        $this->fill($arrayData);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getBankCode()
    {
        return $this->bankCode;
    }

    /**
     * @return int
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @return int
     */
    public function getAgenciaDv()
    {
        return $this->agenciaDv;
    }

    /**
     * @return int
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * @return int
     */
    public function getContaDv()
    {
        return $this->contaDv;
    }

    /**
     * @return int
     */
    public function getDocumentNumber()
    {
        return $this->documentNumber;
    }

    /**
     * @return string
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * @return string
     */
    public function getLegalName()
    {
        return $this->legalName;
    }

    /**
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
}
