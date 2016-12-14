<?php

namespace PagarMe\Sdk\Transfer\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Recipient\Recipient;

class TransferCreate implements Request
{
    /**
     * @var int
     **/
    private $amount;

    /**
     * @var Recipient
     **/
    private $recipient;

    /**
     * @var int
     **/
    private $bankAccountId;

    /**
     * @param int $amount
     * @param Recipient $recipient
     **/
    public function __construct($amount, Recipient $recipient, $bankAccountId)
    {
        $this->amount        = $amount;
        $this->recipient     = $recipient;
        $this->bankAccountId = $bankAccountId;
    }

    public function getPayload()
    {
        return [
            'amount'          =>$this->amount,
            'recipient_id'    =>$this->recipient->getId(),
            'bank_account_id' =>$this->bankAccountId
        ];
    }

    public function getPath()
    {
        return 'transfers';
    }

    public function getMethod()
    {
        return self::HTTP_POST;
    }
}
