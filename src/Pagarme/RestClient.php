<?php
namespace Pagarme;

use Pagarme\Exception as PagarmeException;

/**
 * Class RestClient
 * @package Pagarme
 */
class RestClient
{
    private $http_client;
    private $method;
    private $url;
    private $headers    = Array();
    private $parameters = Array();
    private $curl;

    /**
     * @param array $params
     * @throws Exception
     */
    public function __construct($params = array())
    {
        $this->curl    = curl_init();
        $this->headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        if (! $params["url"])
            throw new PagarmeException("You must set the URL to make a request.");

        else
            $this->url = $params["url"];


        $this
            ->addOption(CURLOPT_RETURNTRANSFER, true)
            ->addOption(CURLOPT_TIMEOUT, 90);


        if ($params["parameters"])
            $this->parameters += $params["parameters"];

        if ($params["method"])
            $this->method = $params["method"];

        if (isset($params["headers"]))
            $this->headers += $params["headers"];


        if ($this->method):

            $upperMethod = strtoupper($this->method);

            if ($upperMethod == 'GET')
                $this->url .= '?' . http_build_query($this->parameters);

            if ($upperMethod == 'POST')
                $this->addOption(CURLOPT_POST, true);

            if (in_array($upperMethod, array('PUT', 'DELETE')))
                $this->addOption(CURLOPT_CUSTOMREQUEST, $upperMethod);

            if (in_array($upperMethod, array('POST', 'PUT', 'DELETE')))
                $this->addOption(CURLOPT_POSTFIELDS, json_encode($this->parameters));

        endif;

        $this
            ->addOption(CURLOPT_URL, $this->url)
            ->addOption(CURLOPT_HTTPHEADER, $this->headers)
            ->addOption(CURLOPT_CAINFO, __DIR__ . "/certs/ca-certificates.crt");

    }

    /**
     * @return array
     * @throws Exception
     */
    public function run()
    {
        $response = curl_exec($this->curl);
        $error    = curl_error($this->curl);

        if ($error)
            throw new PagarmeException("error: " . $error);

        $code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

        curl_close($this->curl);

        return array("code" => $code, "body" => $response);
    }

    /**
     * @param $param
     * @param $value
     * @return $this
     */
    protected function addOption($param, $value)
    {
        curl_setopt($this->curl, $param, $value);

        return $this;
    }
}
