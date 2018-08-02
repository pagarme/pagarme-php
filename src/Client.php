<?php

namespace PagarMe;

use PagarMe\RequestHandler;
use PagarMe\ResponseHandler;
use GuzzleHttp\Client as HttpClient;

class Client
{
    /**
     * @var string
     */
    const BASE_URI = 'https://api.pagar.me:443/1/';

    /**
     * @var \GuzzleHttp\Client
     */
    private $http;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param $apiKey string
     * @param $extras array
     */
    public function __construct($apiKey, array $extras = null)
    {
        $this->apiKey = $apiKey;

        $options = ['base_uri' => self::BASE_URI];

        if (!is_null($extras)) {
            $options = array_merge($options, $extras);
        }

        $this->http = new HttpClient($options);
    }

    /**
     * @param $method string
     * @param $uri string
     * @param $options array
     *
     * @return array
     */
    public function request($method, $uri, $options = [])
    {
        try {
            $response = $this->http->request(
                $method,
                RequestHandler::bindApiKey($uri, $this->apiKey),
                $options
            );

            return ResponseHandler::success($response->getBody());
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
