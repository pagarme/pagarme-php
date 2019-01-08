# Pagar.me PHP SDK

<img src="https://avatars1.githubusercontent.com/u/3846050?s=200&v=4" width="127px" height="127px" align="left"/>

<br>

Integração em PHP para a [Pagar.me API](https://docs.pagar.me/)

<br>

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4c34cc13-e52f-492e-a2f2-dbcd398135a2/mini.png)](https://insight.sensiolabs.com/projects/4c34cc13-e52f-492e-a2f2-dbcd398135a2)
[![Coverage Status](https://coveralls.io/repos/github/pagarme/pagarme-php/badge.svg?branch=V3)](https://coveralls.io/github/pagarme/pagarme-php?branch=V3)

# Índice

- [Instalação e configuração](#Instalação-e-configuração)
- [Utilizando a SDK](#Utilizando-a-SDK)
  - [Parâmetros page e count](#Parâmetros-page-e-count)
  - [Transações](#Transações)
    - [Criando uma transação](#Criando-uma-transação)
    - [Capturando uma transação](#Capturando-uma-transação)
    - [Estornando uma transação](#Estornando-uma-transação)
      - [Estornando uma transação parcialmente](#Estornando-uma-transação-parcialmente)
      - [Estornando uma transação com split](#Estornando-uma-transação-com-split)
    - [Retornando transações](#Retornando-transações)
    - [Retornando uma transação](#Retornando-uma-transação)
    - [Retornando recebíveis de uma transação](#Retornando-recebíveis-de-uma-transação)
    - [Retornando um recebível de uma transação](#Retornando-um-recebível-de-uma-transação)
    - [Retornando o histórico de operações de uma transação](#Retornando-o-histórico-de-operações-de-uma-transação)
    - [Notificando cliente sobre boleto a ser pago](#Notificando-cliente-sobre-boleto-a-ser-pago)
    - [Retornando eventos de uma transação](#Retornando-eventos-de-uma-transação)
    - [Calculando Pagamentos Parcelados](#Calculando-pagamentos-parcelados)
    - [Testando pagamento de boletos](#Testando-pagamento-de-boletos)
  - [Estornos](#Estornos)
  - [Cartões](#Cartões)
    - [Criando cartões](#Criando-cartões)
    - [Retornando cartões](#Retornando-cartões)
    - [Retornando um cartão](#Retornando-um-cartão)
  - [Planos](#Planos)
    - [Criando planos](#Criando-planos)
    - [Retornando planos](#Retornando-planos)
    - [Retornando um plano](#Retornando-um-plano)
    - [Atualizando um plano](#Atualizando-um-plano)
  - [Assinaturas](#Assinaturas)
    - [Criando assinaturas](#Criando-assinaturas)
    - [Split com assinatura](#Split-com-assinatura)
    - [Retornando uma assinatura](#Retornando-uma-assinatura)
    - [Retornando assinaturas](#Retornando-assinaturas)
    - [Atualizando uma assinatura](#Atualizando-uma-assinatura)
    - [Cancelando uma assinatura](#Cancelando-uma-assinatura)
    - [Transações de assinatura](#Transações-de-assinatura)
    - [Pulando cobranças](#Pulando-cobranças)
  - [Postbacks](#Postbacks)
    - [Retornando postbacks](#Retornando-postbacks)
    - [Retornando um postback](#Retornando-um-postback)
    - [Reenviando um Postback](#Reenviando-um-postback)
  - [Saldo do recebedor principal](#Saldo-do-recebedor-principal)
  - [Operações de saldo](#Operações-de-saldo)
    - [Histórico das operações](#Histórico-das-operações)
    - [Histórico de uma operação específica](#Histórico-de-uma-operação-específica)
  - [Recebível](#Recebível)
    - [Retornando recebíveis](#Retornando-recebíveis)
    - [Retornando um recebível](#Retornando-um-recebível)
  - [Transferências](#Transferências)
    - [Criando uma transferência](#Criando-uma-transferência)
    - [Retornando transferências](#Retornando-transferências)
    - [Retornando uma transferência](#Retornando-uma-transferência)
    - [Cancelando uma transferência](#Cancelando-uma-transferência)
  - [Antecipações](#Antecipações)
    - [Criando uma antecipação](#Criando-uma-antecipação)
    - [Obtendo os limites de antecipação](#Obtendo-os-limites-de-antecipação)
    - [Confirmando uma antecipação building](#Confirmando-uma-antecipação-building)
    - [Cancelando uma antecipação pending](#Cancelando-uma-antecipação-pending)
    - [Deletando uma antecipação building](#Deletando-uma-antecipação-building)
    - [Retornando antecipações](#Retornando-antecipações)
  - [Contas bancárias](#Contas-bancárias)
    - [Criando uma conta bancária](#Criando-uma-conta-bancária)
    - [Retornando uma conta bancária](#Retornando-uma-conta-bancária)
    - [Retornando contas bancárias](#Retornando-contas-bancárias)
  - [Recebedores](#Recebedores)
    - [Criando um recebedor](#Criando-um-recebedor)
    - [Retornando recebedores](#Retornando-recebedores)
    - [Retornando um recebedor](#Retornando-um-recebedor)
    - [Atualizando um recebedor](#Atualizando-um-recebedor)
    - [Saldo de um recebedor](#Saldo-de-um-recebedor)
    - [Operações de saldo de um recebedor](#Operações-de-saldo-de-um-recebedor)
    - [Operação de saldo específica de um recebedor](#Operação-de-saldo-específica-de-um-recebedor)
  - [Clientes](#Clientes)
    - [Criando um cliente](#Criando-um-cliente)
    - [Retornando clientes](#Retornando-clientes)
    - [Retornando um cliente](#Retornando-um-cliente)
- [Suporte](#Suporte)
- [Licença](#Licença)
- [Contribuindo](#Contribuindo)

# Instalação e configuração

Para utilizar a biblioteca, você pode instalá-la via composer, com o comando:

```sh
composer require 'pagarme/pagarme-php-v3.7.10'
```

Então, basta importá-la para dentro de seu arquivo e instanciar o objeto `PagarMe`:

```php
require __DIR__.'/vendor/autoload.php';

$apiKey = 'ak_test_grXijQ4GicOa2BLGZrDRTR5qNQxJW0';
$pagarMe =  new \PagarMe\Sdk\PagarMe($apiKey);
```

Nota: todos os exemplos listados aqui utilizam o objeto `$pagarMe` instanciado acima.

# Utilizando a SDK

## Parâmetros page e count

`$page` representa o número da página e `$count` representa a quantidade de registros. Então, se você utilizar, `$page = 2` e `$count = 20` para buscar um objeto, serão retornados os 20~40 objetos mais recentes

## Transações

Nesta seção será explicado como utilizar transações no Pagar.me com essa biblioteca.

### Criando uma transação

```php
<?php
$amount = 1000;
$installments = 1;
$capture = true;
$postbackUrl = 'http://requestb.in/pkt7pgpk';
$metadata = ['idProduto' => 13933139];

$customer = new \PagarMe\Sdk\Customer\Customer(
    [
        'name' => 'John Dove',
        'email' => 'john@site.com',
        'document_number' => '09130141095',
        'address' => [
            'street'        => 'rua teste',
            'street_number' => 42,
            'neighborhood'  => 'centro',
            'zipcode'       => '01227200',
            'complementary' => 'Apto 42',
            'city'          => 'São Paulo',
            'state'         => 'SP',
            'country'       => 'Brasil'
        ],
        'phone' => [
            'ddd'    => "15",
            'number' =>"987523421"
        ],
        'born_at' => '15021994',
        'sex' => 'M'
    ]
);

$card = $pagarMe->card()->create(
    '4242424242424242',
    'JOHN DOVE',
    '0722'
);

$recipient1 = $pagarMe->recipient()->get('re_civb4p9l7004xbm6dhsetkpj8');
$recipient2 = $pagarMe->recipient()->get('re_civb4o6zr003u3m6e8dezzja6');

$splitRule1 = $pagarMe->splitRule()->percentageRule(
    40,
    $recipient1,
    true, // liable
    true, // chargeProcessingFee,
    true // chargeReminder
);

$splitRule2 = $pagarMe->splitRule()->percentageRule(
    60,
    $recipient,
    true, // liable
    true, // chargeProcessingFee,
    false // chargeReminder
);

$splitrules = new PagarMe\Sdk\SplitRule\SplitRuleCollection();
$splitrules[0] = $splitRule1;
$splitrules[1] = $splitRule2;

// Credit Card Transaction
$transaction = $pagarMe->transaction()->creditCardTransaction(
    $amount,
    $card,
    $customer,
    $installments,
    $capture,
    $postbackUrl,
    $metadata,
    ["split_rules" => $splitrules]
);

// Boleto Transaction
$transaction2 = $pagarMe->transaction()->boletoTransaction(
    $amount,
    $customer,
    $postbackUrl,
    $metadata,
    ["split_rules" => $splitrules]
);
```

### Capturando uma transação

```php
<?php
$transaction = $pagarMe->transaction()->get(4752390);
$amountToCapture = 1000;
$metadata = ['idProduto' => '123']; // Parâmetro opcional

$splitRules = new \PagarMe\Sdk\SplitRule\SplitRuleCollection(); // Parâmetro opcional

$recipient1 = $pagarMe->recipient()->get('re_cjqgt03fv02bq4k6e3xbxxbia');
$recipient2 = $pagarMe->recipient()->get('re_cjm0lfmy3001zaq6espflawv2');

$splitRule1 = $pagarMe->splitRule()->percentageRule(
    40,
    $recipient1,
    true, // liable
    true, // chargeProcessingFee,
    true // chargeReminder
);

$splitRule2 = $pagarMe->splitRule()->percentageRule(
    60,
    $recipient2,
    true, // liable
    true, // chargeProcessingFee,
    false // chargeReminder
);

$splitRules[] = $splitRule1;
$splitRules[] = $splitRule2;

$pagarMe->transaction()->capture($transaction, $amountToCapture, $metadata, $splitRules);

```

### Estornando uma transação

```php
<?php
$transaction = $pagarMe->transaction()->get("1627830");

// Credit Card Refund
$transaction = $pagarMe->transaction()->creditCardRefund($transaction);

// Boleto Refund
$bankAccount = $pagarMe->bankAccount()->create(
  '341',
  '0932',
  '58054',
  '5',
  '26268738888',
  'API BANK ACCOUNT',
  '1'
);

$transaction = $pagarMe->transaction()->boletoRefund($transaciton, $bankAccount);
```

Esta funcionalidade também funciona com estornos parciais, ou estornos com split. Por exemplo:

### Estornando uma transação parcialmente

```php
<?php
$transaction = $pagarMe->transaction()->get("1627835");
$amountRefunded = 20000;

// Credit card
$transaction = $pagarMe->transaction()->creditCardRefund(
    $transaction,
    $amountRefunded
);

// Boleto
$transaction = $pagarMe->transaction()->boletoRefund(
    $transaciton,
    $bankAccount,
    $amountRefunded
);
```

### Estornando uma transação com split

```
Não possui essa feature.
```

### Retornando transações

```php
<?php
$transactionList = $pagarMe->transaction()->getList($page, $count);
```

### Retornando uma transação

```php
<?php
$transactionId = "1627864";
$transaction = $pagarMe->transaction()->get($transactionId);
```

### Retornando recebíveis de uma transação

```
Não possui essa feature.
```

### Retornando um recebível de uma transação

```
Não possui essa feature.
```

### Retornando o histórico de operações de uma transação

```
Não possui essa feature.
```

### Notificando cliente sobre boleto a ser pago

```
Não possui essa feature.
```

### Retornando eventos de uma transação

```php
$transactionId = "1627864";
$transaction = $pagarMe->transaction()->get($transactionId);
$transactionEvents = $pagarMe->transaction()->events($transaction);
```

### Calculando pagamentos parcelados

Essa rota não é obrigatória para uso. É apenas uma forma de calcular pagamentos parcelados com o Pagar.me.

Para fins de explicação, utilizaremos os seguintes valores:

`amount`: 1000,
`free_installments`: 4,
`max_installments`: 12,
`interest_rate`: 3

O parâmetro `free_installments` decide a quantidade de parcelas sem juros. Ou seja, se ele for preenchido com o valor `4`, as quatro primeiras parcelas não terão alteração em seu valor original.

Nessa rota, é calculado juros simples, efetuando o seguinte calculo:

valorTotal = valorDaTransacao * ( 1 + ( taxaDeJuros * numeroDeParcelas )  / 100 )

Então, utilizando os valores acima, na quinta parcela, a conta ficaria dessa maneira:

valorTotal = 1000 * (1 + (3 * 5) / 100)

Então, o valor a ser pago na quinta parcela seria de 15% da compra, totalizando 1150.

Você pode usar o código abaixo caso queira utilizar essa rota:

```php
<?php
$amount = 10000;
$rate = 13;
$rateFreeInstallments = 1;
$maxInstallments = 12;
$installments = $pagarMe->calculation()->calculateInstallmentsAmount(
    $amount,
    $rate,
    $rateFreeInstallments,
    $maxInstallments
);

$totalAmount = $installments[2]["total_amount"];
$installmentAmount = $installments[2]["installment_amount"];
```

### Testando pagamento de boletos

```php
<?php
$transaction = $pagarMe->transaction()->payTransaction(1627871);
```

## Estornos

Você pode visualizar todos os estornos que ocorreram em sua conta, com esse código:

```
Não possui essa feature.
```

## Cartões

Sempre que você faz uma requisição através da nossa API, nós guardamos as informações do portador do cartão, para que, futuramente, você possa utilizá-las em novas cobranças, ou até mesmo implementar features como one-click-buy.

### Criando cartões

```php
<?php
//Create with card data
$cardNumber = '4242424242424242';
$cardHolderName = 'Aardvark Silva';
$cardExpirationDate = '1122';
$cardCvv = 123;
$card = $pagarMe->card()->create(
    $cardNumber,
    $cardHolderName,
    $cardExpirationDate,
    $cardCvv
);

//Create with card_hash
$card = $pagarMe->card()->createFromHash('card_hash');
```

### Retornando cartões

```
Não possui essa feature.
```

### Retornando um cartão

```php
$cardId = 'card_cj428xxsx01dt3f6dvre6belx';
$card = $pagarMe->card()->get(cardId);
```

## Planos

Representa uma configuração de recorrência a qual um cliente consegue assinar.
É a entidade que define o preço, nome e periodicidade da recorrência

### Criando planos

```php
$amount = 15000;
$days = 30;
$name = 'The Pro Plan - Platinum  - Best Ever';
$trialDays = 0;
$paymentsMethods = ['credit_card', 'boleto'];
$charges = null;
$installments = 1;

$plan = $pagarMe->plan()->create(
    $amount,
    $days,
    $name,
    $trialDays,
    $paymentsMethods,
    $charges,
    $installments
);
```

### Retornando planos

```php
<?php
$plans = $pagarMe->plan()->getList($page, $count);
```

### Retornando um plano

```php
<?php
$plan = $pagarMe->plan()->get(164526);
```

### Atualizando um plano

```php
<?php
$oldPlan = $pagarMe->plan()->get(163871);
$oldPlan->setName('The Pro Plan - Susan');
$oldPlan->setTrialDays('7');

$newPlan = $pagarMe->plan()->update($oldPlan);
```

## Assinaturas

### Criando assinaturas

```php
<?php
$planId = 136869;
$plan = $pagarMe->plan()->get($planId);

$cardId = 'card_cizri9czn00csfi6e1ygzw9vz';
$card = $pagarMe->card()->get($cardId);
$metadata = ['idAssinatura' => '123'];
$extraAttributtes = [
    'soft_descriptor' => 'Minha empresa'
];

$postbackUrl = 'http://requestb.in/zyn5obzy';

$customer = new \PagarMe\Sdk\Customer\Customer(
    [
        'name' => 'John Dove',
        'email' => 'john@site.com',
        'document_number' => '09130141095',
        'address' => new \PagarMe\Sdk\Customer\Address([
            'street'        => 'rua teste',
            'street_number' => 42,
            'neighborhood'  => 'centro',
            'zipcode'       => '01227200',
            'complementary' => 'Apto 42',
            'city'          => 'São Paulo',
            'state'         => 'SP',
            'country'       => 'Brasil'
        ]),
        'phone' => new \PagarMe\Sdk\Customer\Phone([
            'ddd'    => "15",
            'number' =>"987523421"
        ]),
        'born_at' => '15021994',
        'sex' => 'M'
    ]
);

// Credit card subscription
$subscription = $pagarMe->subscription()->createCardSubscription(
    $plan,
    $card,
    $customer,
    $postbackUrl,
    $metadata,
    $extraAttributes
);

// Boleto Subscription
$subscription = $pagarMe->subscription()->createBoletoSubscription(
    $transaction,
    $customer,
    $postbackUrl,
    $metadata,
    $extraAttributtes
);
```

### Split com assinatura

```php
<?php
$planId = 136869;
$plan = $pagarMe->plan()->get($planId);

$cardId = 'card_cizri9czn00csfi6e1ygzw9vz';
$card = $pagarMe->card()->get($cardId);
$metadata = ['idAssinatura' => '123'];

$postbackUrl = 'http://requestb.in/zyn5obzy';

$customer = new \PagarMe\Sdk\Customer\Customer(
    [
        'name' => 'John Dove',
        'email' => 'john@site.com',
        'document_number' => '09130141095',
        'address' => new \PagarMe\Sdk\Customer\Address([
            'street'        => 'rua teste',
            'street_number' => 42,
            'neighborhood'  => 'centro',
            'zipcode'       => '01227200',
            'complementary' => 'Apto 42',
            'city'          => 'São Paulo',
            'state'         => 'SP',
            'country'       => 'Brasil'
        ]),
        'phone' => new \PagarMe\Sdk\Customer\Phone([
            'ddd'    => "15",
            'number' =>"987523421"
        ]),
        'born_at' => '15021994',
        'sex' => 'M'
    ]
);

$splitRules = new \PagarMe\Sdk\SplitRule\SplitRuleCollection();

$recipient1 = $pagarMe->recipient()->get('re_cjqgt03fv02bq4k6e3xbxxbia');
$recipient2 = $pagarMe->recipient()->get('re_cjm0lfmy3001zaq6espflawv2');

$splitRule1 = $pagarMe->splitRule()->percentageRule(
    40,
    $recipient1,
    true, // liable
    true, // chargeProcessingFee,
    true // chargeReminder
);

$splitRule2 = $pagarMe->splitRule()->percentageRule(
    60,
    $recipient2,
    true, // liable
    true, // chargeProcessingFee,
    false // chargeReminder
);

$splitRules[] = $splitRule1;
$splitRules[] = $splitRule2;


// Credit card subscription
$subscription = $pagarMe->subscription()->createCardSubscription(
    $plan,
    $card,
    $customer,
    $postbackUrl,
    $metadata,
    ['split_rules' => $splitRules]
);

// Boleto Subscription
$subscription = $pagarMe->subscription()->createBoletoSubscription(
    $transaction,
    $customer,
    $postbackUrl,
    $metadata,
    ['split_rules' => $splitRules]
);
```

### Retornando uma assinatura

```php
<?php
$subscription = $pagarMe->subscription()->get(205881);
```

### Retornando assinaturas

```php
<?php
$subscriptions = $pagarMe->subscription()->getList($page, $count);
```

### Atualizando uma assinatura

```php
<?php
$subscription = $pagarMe->subscription()->get(184577);
$newPlan = $pagarMe->plan()->get(166234);
$subscription->setPlan($newPlan);
$subscription->setPaymentMethod('credit_card');
$card = $pagarMe->card()->get('card_cj41mpuhc01bb3f6d8exeo072');
$subscription->setCard($card);

$updatedSubscription = $pagarMe->subscription()->update($subscription);
```

### Cancelando uma assinatura

```php
<?php
$subscriptionId = 205880;
$subscription = $pagarMe->subscription()->get($subscriptionId);
$subscription = $pagarMe->subscription()->cancel($subscription);
```

### Transações de assinatura

```php
<?php
$subscriptionId = 205840;
$subscription = $pagarMe->subscription()->get($subscriptionId);
$transactions = $pagarMe->subscription()->transactions($subscription);
```

### Pulando cobranças

```
Não possui essa feature.
```

## Postbacks

Ao criar uma transação ou uma assinatura você tem a opção de passar o parâmetro `postback_url` na requisição. Essa é uma URL do seu sistema que irá então receber notificações a cada alteração de status dessas transações/assinaturas.

Para obter informações sobre postbacks, 3 informações serão necessárias, sendo elas: `model`, `model_id` e `postback_id`.

`model`: Se refere ao objeto que gerou aquele POSTback. Pode ser preenchido com o valor `transaction` ou `subscription`.

`model_id`: Se refere ao ID do objeto que gerou ao POSTback, ou seja, é o ID da transação ou assinatura que você quer acessar os POSTbacks.

`postback_id`: Se refere à notificação específica. Para cada mudança de status de uma assinatura ou transação, é gerado um POSTback. Cada POSTback pode ter várias tentativas de entregas, que podem ser identificadas pelo campo `deliveries`, e o ID dessas tentativas possui o prefixo `pd_`. O campo que deve ser enviado neste parâmetro é o ID do POSTback, que deve ser identificado pelo prefixo `po_`.

### Retornando postbacks

```php
$transactionId = 1159049;
$transaction = $pagarMe->transaction()->get(transactionId);
$postbacks = $pagarMe->postback()->getList($transaction);
```

### Retornando um postback

```php
<?php
$transactionId = 1159049;
$transaction = $pagarMe->transaction()->get($transactionId);

$postbackId = 'po_ciat6ssga0022k06ng8vxg';
$postbacks = $pagarMe->postback()->get(
    $transaction,
    $postbackId
);
```

### Reenviando um postback

```php
<?php
$transactionId = 1662527;
$transaction = $pagarMe->transaction()->get($transactionId);

$postbackId = 'po_cj4haa8l4131bpi73glgzbnpp';
$postbacks = $pagarMe->postback()->redeliver(
    $transaction,
    $postbackId
);
```

### Validando uma requisição de postback

```php
<?php
$postbackBody = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

if ($pagarMe->postback()->validateRequest($postbackBody, $signature) {
    echo "POSTback válido";
} else {
    echo "POSTback inválido";
}
```

Observação: o código acima serve somente de exemplo para que o processo de validação funcione. Recomendamos que utilize ferramentas fornecidas por bibliotecas ou frameworks para recuperar estas informações de maneira mais adequada.

## Saldo do recebedor principal

Para saber o saldo de sua conta, você pode utilizar esse código:

```php
<?php
$balance = $pagarMe->balance()->get();
```

## Operações de saldo

Com este objeto você pode acompanhar todas as movimentações financeiras ocorridas em sua conta Pagar.me.

### Histórico das operações

```php
<?php
$operationList = $pagarMe->balanceOperation()->getList();
```

### Histórico de uma operação específica

```
$operation = $pagarme->balanceOperation()->get(4861);
```

## Recebível

Objeto contendo os dados de um recebível. O recebível (payable) é gerado automaticamente após uma transação ser paga. Para cada parcela de uma transação é gerado um recebível, que também pode ser dividido por recebedor (no caso de um split ter sido feito).

### Retornando recebíveis

```php
<?php
$payables = $pagarMe->payable()->getList($page, $count);
```

### Retornando um recebível

```php
<?php
$payable = $pagarMe->payable()->get("573310");
```

## Transferências

Transferências representam os saques de sua conta.

### Criando uma transferência

```php
<?php
$amount = 10000;
$recipient = $pagarMe->recipient()->get('re_citkg218g00hl8q6dh1pr5mld');

$transfer = $pagarMe->transfer()->create(
    $amount,
    $recipient
);
```

### Retornando transferências

```php
<?php
$transfers = $pagarMe->transfer()->getList($page, $count)
```

### Retornando uma transferência

```php
<?php
$transfer = $pagarMe->transfer()->get("16264");
```

### Cancelando uma transferência

```php
<?php
$transfer = $pagarMe->transfer()->get("16264");
$canceledTransfer = $pagarMe->transfer()->cancel($transfer);
```

## Antecipações

Para entender o que são as antecipações, você deve acessar esse [link](https://docs.pagar.me/docs/overview-antecipacao).

### Criando uma antecipação

```php
<?php
$recipientId = "re_ciu4jif1j007td56dsm17yew9";
$recipient = new \PagarMe\Sdk\Recipient\Recipient([
    "id" => $recipientId
]);

$date = new \DateTime();
$date->add(new \DateInterval("P10D"));
$timeframe = 'end';
$requestedAmount = 13000;
$build = true;
$anticipation = $pagarMe->bulkAnticipation()->create(
    $recipient,
    $date,
    $timeframe,
    $requestedAmount,
    $build
);
```

### Obtendo os limites de antecipação

```php
<?php
$recipientId = "re_ciu4jif1j007td56dsm17yew9";
$recipient = new \PagarMe\Sdk\Recipient\Recipient([
    "id" => recipientId
]);

$paymentDate = new \DateTime();
$paymentDate->add(new \DateInterval("P10D"));
$timeframe = 'end';
$limits = $pagarMe->bulkAnticipation()->limits(
    $recipient,
    $paymentDate,
    $timeframe
);
```

### Confirmando uma antecipação building

```php
<?php
$recipient = new \PagarMe\Sdk\Recipient\Recipient([
    "id" => "re_ciu4jif1j007td56dsm17yew9"
]);

$anticipation = new PagarMe\Sdk\BulkAnticipation\BulkAnticipation([
    "id" => "ba_cj3uppown001gvm6dqgmjw2ce"
]);

$anticipation = $pagarMe->bulkAnticipation()->confirm(
    $recipient,
    $anticipation
);
```

### Cancelando uma antecipação pending

```php
<?php
$recipient = new \PagarMe\Sdk\Recipient\Recipient([
    "id" => "re_ciu4jif1j007td56dsm17yew9"
]);

$anticipation = new PagarMe\Sdk\BulkAnticipation\BulkAnticipation([
    "id" => "ba_cj3ur2rpl002bpn6ektsnc9lu"
]);

$anticipation = $pagarMe->bulkAnticipation()->cancel(
    $recipient,
    $anticipation
);
```

### Deletando uma antecipação building

```php
<?php
$recipient = new \PagarMe\Sdk\Recipient\Recipient([
    "id" => "re_ciu4jif1j007td56dsm17yew9"
]);

$anticipation = new PagarMe\Sdk\BulkAnticipation\BulkAnticipation([
    "id" => "ba_cj3us6nal0022v86daxfamp4t"
]);

$anticipation = $pagarMe->bulkAnticipation()->delete(
    $recipient,
    $anticipation
);
```

### Retornando antecipações

```php
<?php
$recipietId = "re_ciu4jif1j007td56dsm17yew9";
$page = 1;
$count = 50;
$recipient = new \PagarMe\Sdk\Recipient\Recipient([
    "id" => $recipientId
]);
$anticipationList = $pagarMe->bulkAnticipation()->getList(
    $recipient,
    $page,
    $count
);
```

## Contas bancárias

Contas bancárias identificam para onde será enviado o dinheiro de futuros pagamentos.

### Criando uma conta bancária

```php
<?php
$bankCode = '341';
$agenciaNumber = '0932';
$accountNumber = '58054';
$accountDigit = '5';
$documentNumber = '26268738888';
$legalName = 'Conta Teste 2';
$agenciaDigit = '1';
$bankAccount = $pagarMe->bankAccount()->create(
    $bankCode,
    $agenciaNumber,
    $accountNumber,
    $accountDigit,
    $documentNumber,
    $legalName,
    $agenciaDigit
);
```

## Retornando uma conta bancária

```php
<?php
$bankAccountId = 17411339;
$bankAccount = $pagarMe->bankAccount()->get($bankAccountId);
```

## Retornando contas bancárias

```php
<?php
$bankAccounts = $pagarMe->bankAccount()->getList($page, $count);
```

# Recebedores

Para dividir uma transação entre várias entidades, é necessário ter um recebedor para cada uma dessas entidades. Recebedores contém informações da conta bancária para onde o dinheiro será enviado, e possuem outras informações para saber quanto pode ser antecipado por ele, ou quando o dinheiro de sua conta será sacado automaticamente.

## Criando um recebedor

```php
<?php
$bankAccount = new \PagarMe\Sdk\BankAccount\BankAccount([
    "id" => 17490076
]);

$transferInterval = "monthly";
$transferDay = 13;
$transferEnabled = true;
$automaticAnticipationEnabled = true;
$anticipatableVolumePercentage = 42;
$recipient = $pagarMe->recipient()->create(
    $bankAccount,
    $transferInterval,
    $transferDay,
    $transferEnabled,
    $automaticAnticipationEnabled,
    $anticipatableVolumePercentage
);
```

### Retornando recebedores

```php
<?php
$recipients = $pagarMe->recipient()->getList($page, $count);
```

### Retornando um recebedor

```php
<?php
$recipientId = "re_cj3g1cml000e75f6ehjnpsl9y";
$recipient = $pagarMe->recipient()->get($recipientId);
```

### Atualizando um recebedor

```php
<?php
$recipientId = "re_ciu4jif1j007td56dsm17yew9";
$recipient = new \PagarMe\Sdk\Recipient\Recipient([
    "id" => $recipientId,
    "anticipatable_volume_percentage" => "50",
    "transfer_enabled" => true,
    "transfer_interval" => "monthly",
    "transfer_day" => 15,
    "bank_account" => new \PagarMe\Sdk\BankAccount\BankAccount([
        "id" => "17492906"
    ])
]);

$updatedRecipient = $pagarMe->recipient()->update(
    $recipient
);
```

### Saldo de um recebedor

```php
<?php
$recipientId = "re_cj3g1cml000e75f6ehjnpsl9y";
$recipient = $pagarMe->recipient()->get($recipientId);
$balance = $pagarMe->recipient()->balance($recipient);
```

### Operações de saldo de um recebedor

```php
<?php
$recipientId = "re_cj3g1cml000e75f6ehjnpsl9y";
$recipient = $pagarMe->recipient()->get($recipientId);
$balance = $pagarMe->recipient()->balanceOperations($recipient, $page, $count);
```

### Operação de saldo específica de um recebedor

```php
<?php
$recipientId = "re_ciu4jif1j007td56dsm17yew9";
$recipient = $pagarMe->recipient()->get($recipientId);
$balanceOperationId = 2043993;
$operation = $pagarMe->recipient()->balanceOperation($recipient, $balanceOperationId);
```

## Clientes

Clientes representam os usuários de sua loja, ou negócio. Este objeto contém informações sobre eles, como nome, e-mail e telefone, além de outros campos.

### Criando um cliente

```php
<?php
$customer = $pagarMe->customer()->create(
    'John Dove',
    'john@site.com',
    '09130141095',
    /** @var $address \PagarMe\Sdk\Customer\Address */
    $address,
    /** @var $phone \PagarMe\Sdk\Customer\Phone */
    $phone,
    '15021994',
    'M'
);
```

### Retornando clientes

```php
<?php
$customerList = $pagarMe->customer()->getList();
```

### Retornando um cliente

```php
<?php
$customer = $pagarme->customer()->get(11222);
```

# Suporte

Se você tiver qualquer problema ou sugestão, por favor abra uma issue [aqui](https://github.com/pagarme/pagarme-php/issues).

# Contribuindo

Veja nosso [guia de contribuição](CONTRIBUTING.md) antes de nos enviar sua contribuição.
