<?php

namespace PagarMe;

class RequestHandler
{
    /**
     * @param string $uri
     * @param string $apiKey
     *
     * @return string
     */
    public static function bindApiKey($uri, $apiKey)
    {
        return $uri.'?api_key='.$apiKey;
    }
}
