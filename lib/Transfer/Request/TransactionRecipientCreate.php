<?php

namespace PagarMe\Sdk\Transfer\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Recipient\Recipient;

class TransactionRecipientCreate implements Request
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
     * @param int $amount
     * @param Recipient $recipient
     **/
    public function __construct($amount, Recipient $recipient)
    {
        $this->amount    = $amount;
        $this->recipient = $recipient;
    }

    public function getPayload()
    {
        return [
            'amount'       =>$this->amount,
            'recipient_id' =>$this->recipient->getId()
        ];
    }

    public function getPath()
    {
        return 'transfers';
    }

    public function getMethod()
    {
        return 'POST';
    }
}
