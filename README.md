<img src="https://cdn.rawgit.com/pagarme/brand/9ec30d3d4a6dd8b799bca1c25f60fb123ad66d5b/logo-circle.svg" width="127px" height="127px" align="left"/>

# Pagar.me PHP SDK

PHP integration for [Pagar.me  API](https://docs.pagar.me/api/)

<br>

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4c34cc13-e52f-492e-a2f2-dbcd398135a2/mini.png)](https://insight.sensiolabs.com/projects/4c34cc13-e52f-492e-a2f2-dbcd398135a2)
[![Coverage Status](https://coveralls.io/repos/github/pagarme/pagarme-php/badge.svg?branch=V3)](https://coveralls.io/github/pagarme/pagarme-php?branch=V3)

## Installation
Via Composer
```sh
composer require 'pagarme/pagarme-php'
```

## Usage
### Basic
First, you need to create a PagarMe object with your API-KEY (Available on your [dashboard](https://dashboard.pagar.me/#/myaccount/apikeys))
```php
$apiKey = 'ak_test_grXijQ4GicOa2BLGZrDRTR5qNQxJW0';
$pagarMe =  new \PagarMe\Sdk\PagarMe($apiKey);
```
### Wiki
Check the [wiki](https://github.com/pagarme/pagarme-php/wiki) for detailed documentation.

### Contributing

**Also**, check out our [contributing guide](CONTRIBUTING.md) before you send us any contribution.
