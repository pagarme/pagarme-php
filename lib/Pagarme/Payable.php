<?php

class PagarMe_Payable extends PagarMe_Object {
	protected static $root_url;

	public function __construct($response = array()) {
		parent::__construct($response);
	}

	public static function getUrl()
	{
		$class = get_called_class();
		$search = preg_match("/PagarMe_(.*)/", $class, $matches);
		return '/'. strtolower($matches[1]) . 's';
	}

	public static function all()
	{
		$request = new PagarMe_Request(self::getUrl(), 'GET');
		$response = $request->run();
		$return_array = Array();
		$class = get_called_class();
		foreach($response as $r) {
			$return_array[] = new $class($r);
		}

		return $return_array;
	}

	public static function findById($id)
	{
		$request = new PagarMe_Request(self::getUrl() . '/' . $id, 'GET');
		$response = $request->run();
		$class = get_called_class();
		return new $class($response);
	}

	public static function findByParam($param, $value)
	{
		$request = new PagarMe_Request(self::getUrl(), 'GET');
		$request->setParameters(array($param => $value));
		$response = $request->run();
		$class = get_called_class();
		foreach($response as $r) {
			$return_array[] = new $class($r);
		}

		return $return_array;
	}

	public static function findByRecipientId($id)
	{
		return PagarMe_Payable::findByParam('recipient_id', $id);
	}

	public static function findByTransactionId($id)
	{
		return PagarMe_Payable::findByParam('transaction_id', $id);
	}

	public static function findByStatus($status)
	{
		return PagarMe_Payable::findByParam('status', $status);
	}

}