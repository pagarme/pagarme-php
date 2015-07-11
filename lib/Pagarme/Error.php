<?php

namespace Pagarme;

class Error
{
    private $parameterName;

    private $type;

    private $message;        

    public function __construct($error)
    {
        $this->parameters_name = $error['parameter_name'];
        $this->type = $error['type'];
        $this->message = $error['message'];
    }

    public function getParameterName()
    {
        return $this->parameter_name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getMessage()
    {
        return $this->message;
    } 
}
