# Pagar.me SDK

PHP integration for [Pagar.me  API](https://docs.pagar.me/api/)

## Installation
Via Composer
```sh
composer require 'pagarme/pagarme-php'
```

## Usage
### Basic
First you need to create an PagarMe object with your API-KEY (Avaliable on your [dashboard](https://dashboard.pagar.me/#/myaccount/apikeys))
```php
$apiKey = 'ak_test_grXijQ4GicOa2BLGZrDRTR5qNQxJW0';
$pagarMe =  new \PagarMe\Sdk\PagarMe($apiKey);
```
### Wiki
Check the [wiki](https://github.com/pagarme/pagarme-php/wiki) for detailed documentation.
