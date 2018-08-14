<?php

namespace PagarMe;

final class PagarMeException extends \Exception
{
    /**
     * @param $message string
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
