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
     * @var \Raven_Client
     */
    private $sentryClient;

    /**
     * @param GuzzleClient $client
     * @param string $apiKey
     */
    public function __construct(
        GuzzleClient $client,
        $apiKey,
        \Raven_Client $sentryClient
    ) {
        $this->client       = $client;
        $this->apiKey       = $apiKey;
        $this->sentryClient = $sentryClient;
    }

    /**
     * @param RequestInterface $apiRequest
     * @return \stdClass
     * @throws ClientException
     */
    public function send(RequestInterface $apiRequest)
    {
        $request = $this->client->createRequest(
            $apiRequest->getMethod(),
            $apiRequest->getPath(),
            $this->buildBody($apiRequest)
        );

        try {
            $response = $this->client->send($request);
            return json_decode($response->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\ClientException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();
            $code = $exception->getResponse()->getStatusCode();
            $this->sentryClient->captureException($exception);
            throw new ClientException($response, $code);
        } catch (\GuzzleHttp\Exception\RequestException $exception) {
            $this->sentryClient->captureException($exception);
            throw new ClientException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    /**
     * @param RequestInterface $apiRequest
     * @return array
     */
    private function buildBody(RequestInterface $request)
    {
        return [
            'json' => array_merge(
                $request->getPayload(),
                [
                    'api_key' => $this->apiKey
                ]
            )
        ];
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
