<img src="https://cdn.rawgit.com/pagarme/brand/9ec30d3d4a6dd8b799bca1c25f60fb123ad66d5b/logo-circle.svg" width="127px" height="127px" align="left"/>

# SDK Pagar.me PHP

Integração PHP para a [API Pagar.me](https://docs.pagar.me/api/)

<br>

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4c34cc13-e52f-492e-a2f2-dbcd398135a2/mini.png)](https://insight.sensiolabs.com/projects/4c34cc13-e52f-492e-a2f2-dbcd398135a2)
[![Coverage Status](https://coveralls.io/repos/github/pagarme/pagarme-php/badge.svg?branch=V3)](https://coveralls.io/github/pagarme/pagarme-php?branch=V3)

## Instalação
Via Composer
```sh
composer require 'pagarme/pagarme-php'
```

## Como usar
### Básico
Primeiro você precisa criar um objeto `PagarMe` com sua `API-KEY` (disponível no seu [dashboard](https://dashboard.pagar.me/#/myaccount/apikeys))

```php
$apiKey = 'ak_test_grXijQ4GicOa2BLGZrDRTR5qNQxJW0';
$pagarMe =  new \PagarMe\Sdk\PagarMe($apiKey);
```
### Wiki
Check nossa [wiki](https://github.com/pagarme/pagarme-php/wiki) para documentação detalhada.

### Contribuindo

Veja também nosso [guia de contribuição](CONTRIBUTING.md) antes de nos enviar uma mudança; 
