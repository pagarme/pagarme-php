<?php

namespace PagarMe;

use PagarMe\PagarMeException;

class ResponseHandler
{
    /**
     * @param $payload string
     *
     * @throw \PagarMe\PagarMeException
     * @return \ArrayObject
     */
    public static function success($payload)
    {
        try {
            $response = new \ArrayObject(
                json_decode($payload, true),
                \ArrayObject::STD_PROP_LIST|\ArrayObject::ARRAY_AS_PROPS
            );

            return $response;
        } catch (\Exception $originalException) {
            self::failure($originalException);
        }
    }

    /**
     * @param $originalException \Exception
     *
     * @throw \PagarMe\PagarMeException
     */
    public static function failure(\Exception $originalException)
    {
        $exception = new PagarMeException(
            $originalException->getMessage()
        );
        $exception->originalException = $originalException;

        throw $exception;
    }
}
