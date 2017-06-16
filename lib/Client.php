<?php

namespace PagarMe\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use PagarMe\Sdk\PagarMeException;

class Client
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var GuzzleClient
     */
    private $client;

    /**
     * @var int
     */
    private $timeout;

    /**
     * @param \GuzzleHttp\Client $client
     * @param string $apiKey
     * @param int|null $timeout
     */
    public function __construct(
        GuzzleClient $client,
        $apiKey,
        $timeout = null
    ) {
        $this->client  = $client;
        $this->apiKey  = $apiKey;
        $this->timeout = $timeout;
    }

    /**
     * @param RequestInterface $apiRequest
     * @return \stdClass
     * @throws ClientException
     */
    public function send(RequestInterface $apiRequest)
    {
        $request = $this->buildRequest($apiRequest);

        try {
            $response = $this->client->send(
                $request,
                ['timeout' => $this->timeout]
            );

            return json_decode($response->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\ClientException $exception) {
            $message = $exception->getResponse()->getBody()->getContents();
            $code = $exception->getResponse()->getStatusCode();
            throw new ClientException($message, $code);
        } catch (\GuzzleHttp\Exception\RequestException $exception) {
            throw new ClientException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    /**
     * @param RequestInterface $apiRequest
     * @return mixed
     */
    private function buildRequest($apiRequest)
    {
        if (class_exists('\\GuzzleHttp\\Message\\Request')) {
            return $this->client->createRequest(
                $apiRequest->getMethod(),
                $apiRequest->getPath(),
                ['json' => $this->buildBody($apiRequest)]
            );
        }

        if (class_exists('\\GuzzleHttp\\Psr7\\Request')) {
            return new \GuzzleHttp\Psr7\Request(
                $apiRequest->getMethod(),
                $apiRequest->getPath(),
                ['Content-Type' => 'application/json'],
                json_encode($this->buildBody($apiRequest))
            );
        }

        throw new \Exception("Can't build request");
    }

    /**
     * @param RequestInterface $apiRequest
     * @return array
     */
    private function buildBody(RequestInterface $request)
    {
        return array_merge(
            $request->getPayload(),
            [
                'api_key' => $this->apiKey
            ]
        );
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
}
