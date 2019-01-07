# pagarme-php

Pagar.me's PHP V2 API

[![Build Status](https://travis-ci.org/pagarme/pagarme-php.png?branch=master)](https://travis-ci.org/pagarme/pagarme-php)

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

# Instalação e configuração

Para utilizar a biblioteca, basta baixá-la, e importar o arquivo `Pagarme.php` para dentro de seu projeto. Além disso, você precisa instanciar o objeto com sua chave de API.

```php
require('./pagarme-php/Pagarme.php');
PagarMe::setApiKey('CHAVE_DE_API);
```

# Utilizando a SDK

## Parâmetros page e count

`$page` representa o número da página e `$count` representa a quantidade de registros. Então, se você utilizar, `$page = 2` e `$count = 20` para buscar um objeto, serão retornados os 20~40 objetos mais recentes

## Transações

Nesta seção será explicado como utilizar transações no Pagar.me com essa biblioteca.

### Criando uma transação

```php
<?php
$transaction = new PagarMe_Transaction(array(
    "amount" => 1000,
    "card_number" => "4111111111111111",
    "card_cvv" => "123",
    "card_expiration_date" => "0922",
    "card_holder_name" => "John Doe",
    "payment_method" => "credit_card",
    "customer" => array(
        "external_id" => "1",
        "name" => "John Doe",
        "type" => "individual",
        "country" => "br",
        "documents" => array(
            array(
            "type" => "cpf",
            "number" => "30621143049"
            )
        ),
        "phone_numbers" => array( "+551199999999" ),
        "email" => "aardvark.silva@pagar.me"
    ),
    "billing" => array(
        "name" => "John Doe",
        "address" => array(
        "country" => "br",
        "street" => "Avenida Brigadeiro Faria Lima",
        "street_number" => "1811",
        "state" => "sp",
        "city" => "Sao Paulo",
        "neighborhood" => "Jardim Paulistano",
        "zipcode" => "01451001"
        )
    ),
    "items" => array(
        array(
            "id" => "r123",
            "title" => "Red pill",
            "unit_price" => 10000,
            "quantity" => 1,
            "tangible" => true
        ),
        array(
            "id" => "b123",
            "title" => "Blue pill",
            "unit_price" => 10000,
            "quantity" => 1,
            "tangible" => true
        )
    )
));
```

### Capturando uma transação

```php
<?php
$transaction = PagarMe_Transaction::findById("1627822");

$transaction->capture(3100);
```

### Estornando uma transação

```php
<?php
$transaction = PagarMe_Transaction::findById("1627830");
$transaction->refund();
```

Esta funcionalidade também funciona com estornos parciais, ou estornos com split. Por exemplo:

### Estornando uma transação parcialmente

```php
<?php
$transaction = PagarMe_Transaction::findById("1627835");
$params = array("amount" => 20000);

$transaction->refund($params);
```

### Estornando uma transação com split

```php
<?php
// Credit Card transaction refund example
$transaction = PagarMe_Transaction::findById("ID_DA_TRANSACAO");

$params = array(
    "async" => false,
    "amount" => 20000,
    "split_rules" => array(
        array(
            "id" => "sr_cj41w9m4d01ta316d02edaqav",
            "amount" => "60000",
            "recipient_id" => "re_cj2wd5ul500d4946do7qtjrvk"
        ),
        array(
            "id" => "sr_cj41w9m4e01tb316dl2f2veyz",
            "amount" => "11000",
            "recipient_id" => "re_cj2wd5u2600fecw6eytgcbkd0",
            "charge_processing_fee" => true
        )
    )
);

$transaction->refund($params);

// Boleto transaction refund example
$transaction = PagarMe_Transaction::findById("ID_DA_TRANSACAO");

$params = array(
    "async" => false,
    "amount" => 2000,
    "bank_account" => array(
    "bank_code" => "341",
    "agencia" => "0932",
    "agencia_dv" => "5",
    "conta" => "58054",
    "conta_dv" => "1",
    "document_number" => "26268738888",
    "legal_name" => "API BANK ACCOUNT API"
    ),
    "split_rules" => array(
        array(
            "id" => "ID_DA_SPLIT_RULE",
            "amount" => "1000",
            "recipient_id" => "ID_DO_RECEBDOR"
        ),
        array(
            "id" => "ID_DA_SPLIT_RULE",
            "amount" => "1000",
            "recipient_id" => "ID_DO_RECEBDOR",
            "charge_processing_fee" => true
        )
    )
);

$transaction->refund($params);
```

### Retornando transações

```php
<?php
$transaction = PagarMe_Transaction::all($page, $count)
```

### Retornando uma transação

```php
<?php
$transaction = PagarMe_Transaction::findById("1627864");
```

### Retornando recebíveis de uma transação

```php
<?php
$payables = PagarMe_Payable::findAllByTransactionId(1665560);
```

### Retornando um recebível de uma transação

```php
<?php
$payable = PagarMe_Payable::findTrasactionById(1665560,1714902);
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

```
Não possui essa feature.
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
$ObjectInstallments = Pagarme_Transaction::calculateInstallmentsAmount($amount, $interest_rate, $max_installments, $free_installments);
```

### Testando pagamento de boletos

```php
<?php
$transaction = PagarMe_Transaction::findById("1627871");
$transaction->setStatus('paid');
$transaction->save();
```

## Estornos

Da mesma forma que estornos, você pode visualizar todos os chargebacks que ocorreram em sua conta.

```php
<?php
$transactionChargebacks = $pagarme->refunds()->getList();
```

## Cartões

Sempre que você faz uma requisição através da nossa API, nós guardamos as informações do portador do cartão, para que, futuramente, você possa utilizá-las em novas cobranças, ou até mesmo implementar features como one-click-buy.

### Criando cartões

```php
<?php
$card = new PagarMe_Card(array(
    "card_number" => "4018720572598048",
    "card_holder_name" => "Aardvark Silva",
    "card_expiration_month" => 11,
    "card_expiration_year" => 22,
    "card_cvv" => "123",
));

$card->create();
```

### Retornando cartões

```php
<?php
$cards = PagarMe_Card::all($page, $count)
```

### Retornando um cartão

```php
<?php
$card = PagarMe_Card::findById("card_cj428xxsx01dt3f6dvre6belx");
```

## Planos

Representa uma configuração de recorrência a qual um cliente consegue assinar.
É a entidade que define o preço, nome e periodicidade da recorrência

### Criando planos

```php
<?php
$plan = new PagarMe_Plan(array(
    "amount" => 15000,
    "days" => 30,
    "name" => "The Pro Plan - Platinum  - Best Ever"
));

$plan->create();
```

### Retornando planos

```php
<?php
$plans = PagarMe_Plan::all($page, $count);
```

### Retornando um plano

```php
<?php
$plan = PagarMe_Plan::findById("164526");
```

### Atualizando um plano

```php
<?php
$plan = PagarMe_Plan::findById("163871");

$plan->setName("The Pro Plan - Susan");
$plan->setTrialDays("7");

$plan->save();
```

## Assinaturas

### Criando assinaturas

```php
<?php
$plan = PagarMe_Plan::findById("13850");

$subscription = new PagarMe_Subscription(array(
    "plan_id" => '123456',
    "card_number" => "4901720080344448",
    "card_holder_name" => "Jose da Silva",
    "card_expiration_month" => 12,
    "card_expiration_year" => 15,
    "card_cvv" => "123",
    "customer" => array(
        "email" => "time@unix.com",
        "name" => "Unix Time",
        "document_number" => "75948706036",
        "address" => array(
            "street" => "Rua de Teste",
            "street_number" => "100",
            "complementary" => "Apto 666",
            "neighborhood" => "Bairro de Teste",
            "zipcode" => "11111111"
        ),
        "phone" => array(
            "ddd" => "01",
            "number" => "923456780"
        ),
        "sex" => "other",
        "born_at" => "1970-01-01",
    ),
    "metadata" => array(
        "foo" => "bar"
    )
));

$subscription->create();
```

### Split com assinatura

```php
<?php
$subscription = new PagarMe_Subscription(array(
    'plan_id' => 123456,
    'card_id' => 'card_abc123456',
    'payment_method' => 'credit_card',
    'postback_url' => 'http://www.pudim.com.br',
    'customer' => array(
        'email' => 'time@unix.com',
        'name' => 'Unix Time',
        'document_number' => '75948706036',
        'address' => array(
            'street' => 'Rua de Teste',
            'street_number' => '100',
            'complementary' => 'Apto 666',
            'neighborhood' => 'Bairro de Teste',
            'zipcode' => '88370801'
        ),
        'phone' => array(
            'ddd' => '01',
            'number' => '923456780'
        ),
        'sex' => 'other',
        'born_at' => '1970-01-01',
    ),
    'split_rules' => array(
        array(
            'recipient_id' => 're_abc1234abc1234abc1234abc1',
            'percentage' => 20,
            'liable' => true,
            'charge_processing_fee' => true,
        ),
        array(
            'recipient_id' => 're_abc1234abc1234abc1234abc1',
            'percentage' => 80,
            'liable' => true,
            'charge_processing_fee' => true,
        )
    ),
    'metadata' => array(
        'foo' => 'bar'
    )
));

$subscription->create();
```

### Retornando uma assinatura

```php
<?php
$subscription = PagarMe_Subscription::findById(205881);
```

### Retornando assinaturas

```php
<?php
$subscription = PagarMe_Subscription::all($page, $count);
```

### Atualizando uma assinatura

```php
<?php
$subscription = PagarMe_Subscription::findById(205881);
$subscription->setPaymentMethod("credit_card");
$subscription->setCardId("card_cj41mpuhc01bb3f6d8exeo072");
$subscription->plan->id = "166234";

$subscription->save();
```

### Cancelando uma assinatura

```php
<?php
$subscription = PagarMe_Subscription::findById(205880);
$subscription->cancel();
```

### Transações de assinatura

```php
<?php
$subscription = PagarMe_Subscription::findById(205881);

$transactions = $subscription->getTransactions();
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

```
Não possui essa feature.
```

### Retornando um postback

```
Não possui essa feature.
```

### Reenviando um postback

```
Não possui essa feature.
```

### Validando uma requisição de postback

```php
<?php
$postbackPayload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

if(PagarMe::validateRequestSignature($postbackPayload, $signature)){
 	echo "Postback válido!" ;
}else{
  echo "Postback inválido";
}

```

Observação: o código acima serve somente de exemplo para que o processo de validação funcione. Recomendamos que utilize ferramentas fornecidas por bibliotecas ou frameworks para recuperar estas informações de maneira mais adequada.

## Saldo do recebedor principal

Para saber o saldo de sua conta, você pode utilizar esse código:

```
Não possui essa feature.
```

## Operações de saldo

Com este objeto você pode acompanhar todas as movimentações financeiras ocorridas em sua conta Pagar.me.

### Histórico das operações

```
Não possui essa feature.
```

### Histórico de uma operação específica

```
Não possui essa feature.
```

## Recebível

Objeto contendo os dados de um recebível. O recebível (payable) é gerado automaticamente após uma transação ser paga. Para cada parcela de uma transação é gerado um recebível, que também pode ser dividido por recebedor (no caso de um split ter sido feito).

### Retornando recebíveis

```php
<?php
$payables = PagarMe_Payable::all();
```

### Retornando um recebível

```
Não possui essa feature.
```

## Transferências

Transferências representam os saques de sua conta.

### Criando uma transferência

```
Não possui essa feature.
```

### Retornando transferências

```
Não possui essa feature.
```

### Retornando uma transferência

```
Não possui essa feature.
```

### Cancelando uma transferência

```
Não possui essa feature.
```

## Antecipações

Para entender o que são as antecipações, você deve acessar esse [link](https://docs.pagar.me/docs/overview-antecipacao).

### Criando uma antecipação

```
Não possui essa feature.
```

### Obtendo os limites de antecipação

```
Não possui essa feature.
```

### Confirmando uma antecipação building

```
Não possui essa feature.
```

### Cancelando uma antecipação pending

```
Não possui essa feature.
```

### Deletando uma antecipação building

```
Não possui essa feature.
```

### Retornando antecipações

```
Não possui essa feature.
```

## Contas bancárias

Contas bancárias identificam para onde será enviado o dinheiro de futuros pagamentos.

### Criando uma conta bancária

```php
<?php
$bankAccount = new PagarMe_Bank_Account(array(
    "bank_code" => "341",
    "agencia" => "0932",
    "agencia_dv" => "5",
    "conta" => "58054",
    "conta_dv" => "1",
    "document_number" => "26268738888",
    "legal_name" => "BANK ACCOUNT OWNER"
));
$bankAccount->create();
```

## Retornando uma conta bancária

```php
<?php
$bank_account = PagarMe_Bank_Account::findById("17365090");
```

## Retornando contas bancárias

```php
<?php
$bankAccounts = PagarMe_Bank_Account::all($page, $count);
```

# Recebedores

Para dividir uma transação entre várias entidades, é necessário ter um recebedor para cada uma dessas entidades. Recebedores contém informações da conta bancária para onde o dinheiro será enviado, e possuem outras informações para saber quanto pode ser antecipado por ele, ou quando o dinheiro de sua conta será sacado automaticamente.

## Criando um recebedor

```php
<?php
 $recipient = new PagarMe_Recipient(array(
    "transfer_interval" => "weekly",
    "transfer_day" => 5,
    "transfer_enabled" => true,
    "automatic_anticipation_enabled" => true,
    "anticipatable_volume_percentage" => 85,
    "bank_account_id" => 4841
));

$recipient->create();
```

### Retornando recebedores

```php
<?php
$recipients = PagarMe_Recipient::all($page, $count);
```

### Retornando um recebedor

```php
<?php
$recipientId = "re_cixm61j7e00doin6de8ocgttb";
$recipient = PagarMe_Recipient::findById($recipientId);
```

### Atualizando um recebedor

```php
<?php
$recipient = PagarMe_Recipient::findById("re_cixm61j7e00doin6de8ocgttb");
$recipient->setAnticipatableVolumePercentage(80);
$recipient->setBankAccountId(17365100);

$recipient->save();
```

### Saldo de um recebedor

```
Não possui essa feature.
```

### Operações de saldo de um recebedor

```
Não possui essa feature.
```

### Operação de saldo específica de um recebedor

```
Não possui essa feature.
```

## Clientes

Clientes representam os usuários de sua loja, ou negócio. Este objeto contém informações sobre eles, como nome, e-mail e telefone, além de outros campos.

### Criando um cliente

```php
<?php
$customer = new PagarMe_Customer(array(
    "external_id" => "1",
    "name" => "John Doe",
    "type" => "individual",
    "country" => "br",
    "documents" => array(
        array(
            "type" => "cpf",
            "number" => "30621143049"
        )
    ),
    "phone_numbers" => array( "+551199999999" ),
    "email" => "aardvark.silva@pagar.me"
));

$customer->create();
```

### Retornando clientes

```php
<?php
$customer = PagarMe_Customer::all()
```

### Retornando um cliente

```php
<?php
$customer = PagarMe_Customer::findById("ID_DO_CLIENTE");
```

# Suporte

Se você tiver qualquer problema ou sugestão, por favor abra uma issue [aqui](https://github.com/pagarme/pagarme-php/issues).

# Licença

Veja [aqui](LICENSE).
