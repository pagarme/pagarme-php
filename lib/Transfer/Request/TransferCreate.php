<?php

namespace PagarMe\Sdk\Transfer\Request;

use PagarMe\Sdk\RequestInterface;
use PagarMe\Sdk\Recipient\Recipient;

class TransferCreate implements RequestInterface
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @var Recipient
     */
    private $recipient;

    /**
     * @var int
     */
    private $bankAccountId;

    /**
     * @param int $amount
     * @param Recipient $recipient
     */
    public function __construct($amount, Recipient $recipient, $bankAccountId)
    {
        $this->amount        = $amount;
        $this->recipient     = $recipient;
        $this->bankAccountId = $bankAccountId;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [
            'amount'          =>$this->amount,
            'recipient_id'    =>$this->recipient->getId(),
            'bank_account_id' =>$this->bankAccountId
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'transfers';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_POST;
    }
}
