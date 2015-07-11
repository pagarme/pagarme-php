<?php

namespace Pagarme;

use \Exception as StdException;

class Request
{
    private $parameters = array();

    private $headers = array();

    public function send($path, $method, $live = PagarMe::LIVE) 
    {
        if(!PagarMe::getApiKey()) {
            throw new Exception('You need to configure API key before performing requests.');
        }

        $this->parameters = array_merge($this->parameters, array(
            'api_key' => PagarMe::getApiKey()
        ));
        // var_dump($this->parameters);
        // $this->headers = (PagarMe::live) ? array("X-Live" => 1) : array();
        $client = new RestClient(array(
            'method' => $method,
            'url' => $this->buildRequestUrl($path),
            'headers' => $this->headers,
            'parameters' => $this->parameters 
        ));    

        $response = $client->run();
        $decode = json_decode($response['body'], true);

        if ($decode === null) {
            throw new Exception("Failed to decode json from response.\n Response: {$response}");
        }

        if ($response['code'] === 200) {
            return $decode;
        }
            
        throw Exception::buildWithFullMessage($decode);
    }

    public function setParameters($parameters)
       {
        $this->parameters = $parameters;
    }

    public function getParameters() 
    {
        return $this->parameters;
    }

    private function buildRequestUrl($path)
    {
        return PagarMe::ENDPOIT . '/' . PagarMe::API_VERSION . $path;
    }
}