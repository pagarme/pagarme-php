<?php

namespace PagarMe;

class RequestHandler
{
    /**
     * @param $uri string
     * @param $apiKey string
     *
     * @return string
     */
    public static function bindApiKey($uri, $apiKey)
    {
        return $uri.'?api_key='.$apiKey;
    }
}
