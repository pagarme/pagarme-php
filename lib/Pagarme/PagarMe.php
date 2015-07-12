<?php

namespace Pagarme;

class PagarMe 
{
    public static $api_key;

    const LIVE = 1;

    const ENDPOIT = 'https://api.pagar.me';

    const API_VERSION = '1';

    public static function setApiKey($api_key)
    {
        self::$api_key = $api_key; 
    }

    public static function getApiKey()
    {
        return self::$api_key;
    }

    public static function validateFingerprint($id, $fingerprint)
    {
        return sha1($id . '#' . self::$api_key) == $fingerprint;
    }
}