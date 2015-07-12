<?php

namespace Pagarme;

use \Exception as BaseException;

class Exception extends BaseException
{
    private $url;

    private $method;

    private $returnCode;

    private $parameterName;

    private $type;

    private $errors;

    /**
     * Builds with a message and a response from the server
     */
    public function __construct($message = null, $responseError = null) 
    {
        $this->url = (isset($responseError['url'])) ? $responseError['url'] : null;
        $this->method = (isset($responseError['method'])) ? $responseError['method'] : null;

        if (isset($responseError['errors'])) {
            foreach ($responseError['errors'] as $error) {
                $this->errors[] = new Error($error);
            }
        }

        parent::__construct($message);
    }

    /**
     * Builds an exception based on an error object
     */
    public static function buildWithError($error)
    {
        $instance = new self($error->getMessage());
        return $instance;
    }

    /**
     * Builds an exception with the server response and joins all the errors
     */
    public static function buildWithFullMessage($responseError)
    {
        $joinedMessages = null;

        foreach ($responseError['errors'] as $error) {
            $joinedMessages .= $error['message'] . "\n";
        }

        return new self($joinedMessages, $responseError);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getUrl() 
    {
        return $this->url;
    }

    public function getMethod() 
    {
        return $this->method;
    }

    public function getReturnCode() 
    {
        return $this->returnCode;
    }
}