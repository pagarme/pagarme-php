<?php

class PagarMe_Request extends PagarMe
{
	private $path;
	private $method;
	private $parameters = Array();
	private $headers;
	private $live;

	public function __construct($path, $method, $live = PagarMe::live)
	{
		$this->method = $method;
		$this->path = $path;
		$this->live = $live;
	}
	public function run()
	{
		if(!parent::getApiKey()) {
			throw new Exception("You need to configure API key before performing requests.");
		}

		$this->parameters = array_merge($this->parameters, array( "api_key" => parent::getApiKey()));

		$client = new RestClient(array("method" => $this->method, "url" => $this->full_api_url($this->path), "headers" => $this->headers, "parameters" => $this->parameters ));
		$response = $client->run();
		$decode = json_decode($response["body"], true);
		if($decode === NULL) {
			throw new Exception("Invalid JSON received from Pagarme API: (".$response.")");
		} else {
			if($response["code"] == 200) {
				return $decode;

			} else {
				throw PagarMe_Exception::buildWithFullMessage($decode);
			}
		}
	}


	public function setParameters($parameters)
   	{
		$this->parameters = $parameters;
	}

	public function getParameters()
	{
		return $this->parameters;
	}
}
