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
     * @var string | Chave de encriptação
     */
    private $encryptionKey;

    /**
     * @var GuzzleClient | Client do Guzzle
     */
    private $client;

    /**
     * @param GuzzleClient $client
     * @param string $apiKey
     */
    public function __construct(GuzzleClient $client, $apiKey, $encryptionKey)
    {
        $this->client        = $client;
        $this->apiKey        = $apiKey;
        $this->encryptionKey = $encryptionKey;
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

    /**
     * @param Request $apiRequest
     * @return array
     */
    private function getAuthentication(Request $request)
    {
        if ($request->getAuthenticationMethod() == Request::API_KEY) {
            return [
                'api_key' => $this->apiKey
            ];
        }

        if ($request->getAuthenticationMethod() == Request::ENCRYPTION_KEY) {
            return [
                'ENCRYPTION_KEY' => $this->encryptionKey
            ];
        }

        throw new ClientException(
            sprintf(
                'Unknown authentication method provided "%s"',
                $request->getAuthenticationMethod()
            ),
            $exception->getCode()
        );
    }
}
