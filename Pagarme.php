<?php

if (!function_exists('curl_init')) {
	throw new Exception('PagarMe needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('PagarMe needs the JSON PHP extension.');
}


require(dirname(__FILE__) . '/lib/Pagarme/Pagarme.php');
require(dirname(__FILE__) . '/lib/Pagarme/Exception.php');
require(dirname(__FILE__) . '/lib/Pagarme/TransactionException.php');
require(dirname(__FILE__) . '/lib/Pagarme/ApiException.php');
require(dirname(__FILE__) . '/lib/Pagarme/RestClient.php');
require(dirname(__FILE__) . '/lib/Pagarme/Request.php');
require(dirname(__FILE__) . '/lib/Pagarme/model.php');
require(dirname(__FILE__) . '/lib/Pagarme/TransactionCommon.php');
require(dirname(__FILE__) . '/lib/Pagarme/Transaction.php');
require(dirname(__FILE__). '/lib/Pagarme/Plan.php');
require(dirname(__FILE__) . '/lib/Pagarme/Subscription.php');
require(dirname(__FILE__) . '/lib/Pagarme/Customer.php');
require(dirname(__FILE__) . '/lib/Pagarme/Address.php');
require(dirname(__FILE__) . '/lib/Pagarme/Phone.php');
?>
