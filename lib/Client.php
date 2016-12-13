<?php

namespace PagarMe\Sdk;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Message\Response as Response;

class Client
{
    /**
     * @var string | Chave da API
     */
    private $apiKey;

    /**
     * @var GuzzleClient | Client do Guzzle
     */
    private $client;

    /**
     * @param GuzzleClient $client
     * @param string $apiKey
     */
    public function __construct(GuzzleClient $client, $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @param Request $apiRequest
     * @return object
     * @throws ClientException
     */
    public function send(Request $apiRequest)
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
            throw new ClientException($response, $code);
        } catch (\GuzzleHttp\Exception\RequestException $exception) {
            throw new ClientException(
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    /**
     * @param Request $apiRequest
     * @return array
     */
    private function buildBody(Request $request)
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
}
