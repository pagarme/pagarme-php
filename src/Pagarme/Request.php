<?php
namespace Pagarme;

use Pagarme\Exception as PagarmeException;

/**
 * Class Request
 * @package Pagarme
 */
class Request extends Core
{
    private $path;
    private $method;
    private $parameters = Array();
    private $headers;
    private $live;

    /**
     * @param $path
     * @param $method
     * @param int $live
     */
    public function __construct($path, $method, $live = Core::live)
    {
        $this->method = $method;
        $this->path   = $path;
        $this->live   = $live;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function run()
    {
        if (! parent::getApiKey())
            throw new PagarmeException("You need to configure API key before performing requests.");


        $this->parameters = array_merge($this->parameters, array("api_key" => parent::getApiKey()));
        // var_dump($this->parameters);
        // $this->headers = (PagarMe::live) ? array("X-Live" => 1) : array();
        $client = new RestClient(array(
            "method"     => $this->method,
            "url"        => $this->full_api_url($this->path),
            "headers"    => $this->headers,
            "parameters" => $this->parameters
        ));

        $response = $client->run();
        $decode   = json_decode($response["body"], true);

        if (! is_array($decode)) {
            var_dump($response);
            var_dump($decode);
            throw new Exception("Failed to decode json from response.\n\n Response: " . $response);

        } else {
            if ($response["code"] == 200)
                return $decode;

            else
                throw PagarmeException::buildWithFullMessage($decode);
        }
    }


    /**
     * @param $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
