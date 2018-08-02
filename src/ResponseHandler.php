<?php

namespace PagarMe;

use ArrayObject;

class ResponseHandler
{
    /**
     * @param $payload string
     *
     * @return \ArrayObject
     */
    public static function success($json)
    {
        $payload = json_decode($json, true);

        $response = new ArrayObject($payload);

        $response->setFlags(
            ArrayObject::STD_PROP_LIST|ArrayObject::ARRAY_AS_PROPS
        );

        return $response;
    }
}
