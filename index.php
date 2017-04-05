<?php
include 'vendor/autoload.php';
date_default_timezone_set('America/Sao_Paulo');

$apiKey        = 'ak_test_fEdp850tlXjulV60cGxnUtD3hLtl7C';
$encryptionKey = 'ek_test_q5vZGIkmbWJHcdYbN8NatCFaEuWSQX';

$pagarMe =  new \PagarMe\Sdk\PagarMe($apiKey);

$account = $pagarMe->bankAccount()->get(17424066);

var_dump($account);
