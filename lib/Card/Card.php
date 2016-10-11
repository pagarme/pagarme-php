<?php

namespace PagarMe\Sdk\Card;

class Card
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var int | Identificador do cartão
     */
    private $id;

    /**
     * @var string | Data de criação do objeto card
     */
    private $dateCreated;

    /**
     * @var string | Data de atualização do objeto card
     */
    private $dateUpdated;

    /**
     * @var string | Marca da operadora do cartão
     */
    private $brand;

    /**
     * @var string | Nome do portador do cartão
     */
    private $holderName;

    /**
     * @var int | Primeiros dígitos do cartão (6 dígitos)
     */
    private $firstDigits;

    /**
     * @var int | Últimos dígitos do cartão (4 dígitos)
     */
    private $lastDigits;

    /**
     * @var string | Hash que permite comparar dois cartões através de seus fingerprints para saber se são o mesmo
     */
    private $fingerprint;

    /**
     * @var object | Objeto com dados do comprador
     */
    private $customer;

    /**
     * @var string | Hash dos dados de cartao
     */
    private $hash;

    /**
     * @var boolean | Propriedade para verificar a validade do cartão
     */
    private $valid;

    /**
     * @param array $arrayData
     */
    public function __construct($arrayData)
    {
        $this->fill($arrayData);
    }

    /**
     * @codeCoverageIgnore
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @codeCoverageIgnore
     * @return int
     */
    public function getFirstDigits()
    {
        return $this->firstDigits;
    }

    /**
     * @codeCoverageIgnore
     * @return int
     */
    public function getLastDigits()
    {
        return $this->lastDigits;
    }

    /**
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return string
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getHolderName()
    {
        return $this->holderName;
    }

    /**
     * @return string
     */
    public function getFingerprint()
    {
        return $this->fingerprint;
    }

    /**
     * @return object
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return boolean
     */
    public function getValid()
    {
        return $this->valid;
    }
}
