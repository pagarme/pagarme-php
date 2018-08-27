<?php

namespace PagarMe;

use PagarMe\RequestHandler;
use PagarMe\ResponseHandler;
use PagarMe\Endpoints\Transactions;
use PagarMe\Endpoints\Customers;
use PagarMe\Endpoints\Cards;
use PagarMe\Endpoints\Recipients;
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
     * @var \PagarMe\Endpoints\Transactions
     */
    private $transactions;

    /**
     * @var \PagarMe\Endpoints\Customers
     */
    private $customers;

    /**
     * @var \PagarMe\Endpoints\Cards
     */
    private $cards;

    /**
     * @var \PagarMe\Endpoints\Recipients
     */
    private $recipients;

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

        $this->transactions = new Transactions($this);
        $this->customers = new Customers($this);
        $this->cards = new Cards($this);
        $this->recipients = new Recipients($this);
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

    /**
     * @return \PagarMe\Endpoints\Transactions
     */
    public function transactions()
    {
        return $this->transactions;
    }

    /**
     * @return \PagarMe\Endpoints\Customers
     */
    public function customers()
    {
        return $this->customers;
    }

    /**
     * @return \PagarMe\Endpoints\Cards
     */
    public function cards()
    {
        return $this->cards;
    }

    /**
     * @return \PagarMe\Endpoints\Recipients
     */
    public function recipients()
    {
        return $this->recipients;
    }
}
