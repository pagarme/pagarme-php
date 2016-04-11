<?php

class PagarMe_Search extends PagarMe_Object {
	protected static $root_url;

	public function __construct($response = array()) {
		parent::__construct($response);
	}

	public static function getUrl()
	{
		$class = get_called_class();
		$search = preg_match("/PagarMe_(.*)/", $class, $matches);
		return '/'. strtolower($matches[1]);
	}

	public static function search($type, $query = '', $search_type = '')
	{
		$params = array(
			'type'	=> $type,
		);

		if ( $query != '' ) {
			$params['query'] = $query;
		}

		if ( $search_type != '' ) {
			$params['search_type'] = $search_type;
		}

		$request = new PagarMe_Request(self::getUrl(), 'GET');
		$request->setParameters($params);
		$response = $request->run();
		$class = get_called_class();
		return new $class($response);
	}

	public static function searchTransactionByMetadata($metadata, $value)
	{

		$metadata = 'metadata.' . $metadata;

		$query = array(
			'query' => array(
				'bool' => array(
					'must' => array(
						'term' => array(
							$metadata => $value
						)
					)
				)
			)
		);

		return PagarMe_Search::search('transaction', $query);
	}

}