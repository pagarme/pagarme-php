<?php

namespace PagarMe;

use PagarMe\Exceptions\PagarMeException;
use PagarMe\Exceptions\InvalidJsonException;

class ResponseHandler
{
    /**
     * @param string $payload
     *
     * @throws \PagarMe\Exceptions\InvalidJsonException
     * @return \ArrayObject
     */
    public static function success($payload)
    {
        return self::toJson($payload);
    }

    /**
     * @param \Exception $originalException
     *
     * @throws \Exception
     */
    public static function failure(\Exception $originalException)
    {
        throw self::parseException($originalException);
    }

    /**
     * @param \Exception $guzzleException
     *
     * @return \Exception
     */
    private static function parseException($guzzleException)
    {
        $body = $guzzleException->getResponse()->getBody()->getContents();

        try {
            $jsonError = self::toJson($body);
        } catch (InvalidJsonException $invalidJson) {
            return $guzzleException;
        }

        return new PagarMeException(
            $jsonError->errors[0]->type,
            $jsonError->errors[0]->parameter_name,
            $jsonError->errors[0]->message
        );
    }

    private static function toJson($json)
    {
        $jsonError = json_decode($json);

        if (json_last_error() != \JSON_ERROR_NONE) {
            throw new InvalidJsonException(json_last_error_msg());
        }

        return $jsonError;
    }
}
