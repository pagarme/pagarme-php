<?php

namespace PagarMe;

use PagarMe\RequestHandler;
use PagarMe\ResponseHandler;
use PagarMe\Endpoints\Transactions;
use GuzzleHttp\Client as HttpClient;
use PagarMe\Exceptions\InvalidJsonException;

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
     * @param string $apiKey
     * @param array|null $extras
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
     * @param string method
     * @param string $uri
     * @param array $options
     *
     * @throws \PagarMe\PagarMeException
     * @return \ArrayObject
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
        } catch (InvalidJsonException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            ResponseHandler::failure($exception);
        }
    }

    public function transactions()
    {
        return new Transactions($this);
    }
}
