<?php

namespace PagarMe;

final class PagarMeException extends \Exception
{
    /**
     * @var \Exception
     */
    public $originalException;

    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
