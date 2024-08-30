<?php

namespace PagarMe\Sdk;

use GuzzleHttp\Client as GuzzleClient;

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
     * @deprecated
     */
    private $timeout;

    /**
     * @var array
     */
    private $requestOptions = [];

    /**
     * @param \GuzzleHttp\Client $client
     * @param string $apiKey
     * @param int|null $timeout
     */
    public function __construct(
        GuzzleClient $client,
        $apiKey,
        $timeout = null,
        $requestOptions = []
    ) {
        $this->client  = $client;
        $this->apiKey  = $apiKey;
        $this->requestOptions = array_merge(
            ['timeout' => $timeout],
            $requestOptions
        );
    }

    /**
     * @param RequestInterface $apiRequest
     * @return \stdClass
     * @throws ClientException
     */
    public function send(RequestInterface $apiRequest)
    {
        $options = array_merge($this->requestOptions, [
            'body' => json_encode($this->buildBody($apiRequest)),
            'headers' => [
                'Content-Type' => 'application/json',
                'ServiceRefererName' => '62fa7b926ae07600199d7dfc'
            ]
        ]);

        try {
            $response = $this->client->request($apiRequest->getMethod(), $apiRequest->getPath(), $options);
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

        return json_decode($response->getBody()->getContents());
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
