<?php

namespace PagarMe\Exceptions;

final class PagarMeException extends \Exception
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $parameterName;

    /**
     * @param string $type
     * @param string $parameterName
     */
    public function __construct($type, $parameterName, $errorMessage)
    {
        $this->type = $type;

        $this->parameterName = $parameterName;

        parent::__construct($errorMessage);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getParameterName()
    {
        return $this->parameterName;
    }
}
