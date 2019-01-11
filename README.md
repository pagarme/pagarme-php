# Introdução

Essa SDK foi construída com o intuito de torná-la flexível, de forma que todos possam utilizar todas as features, de todas as versões de API.

Você pode acessar a documentação oficial do Pagar.me acessando esse [link](https://docs.pagar.me).

## Índice

- [Instalação](#instalação)
- [Configuração](#configuração)
- [Transações](#transações)
  - [Criando uma transação](#criando-uma-transação)
  - [Capturando uma transação](#capturando-uma-transação)
  - [Estornando uma transação](#estornando-uma-transação)
    - [Estornando uma transação parcialmente](#estornando-uma-transação-parcialmente)
    - [Estornando uma transação com split](#estornando-uma-transação-com-split)
  - [Retornando transações](#retornando-transações)
  - [Retornando uma transação](#retornando-uma-transação)
  - [Retornando recebíveis de uma transação](#retornando-recebíveis-de-uma-transação)
  - [Retornando um recebível de uma transação](#retornando-um-recebível-de-uma-transação)
  - [Retornando o histórico de operações de uma transação](#retornando-o-histórico-de-operações-de-uma-transação)
  - [Notificando cliente sobre boleto a ser pago](#notificando-cliente-sobre-boleto-a-ser-pago)
  - [Retornando eventos de uma transação](#retornando-eventos-de-uma-transação)
  - [Calculando Pagamentos Parcelados](#calculando-pagamentos-parcelados)
  - [Testando pagamento de boletos](#testando-pagamento-de-boletos)
- [Estornos](#estornos)
- [Chargebacks](#chargebacks)
- [Cartões](#cartões)
  - [Criando cartões](#criando-cartões)
  - [Retornando cartões](#retornando-cartões)
  - [Retornando um cartão](#retornando-um-cartão)
- [Planos](#planos)
  - [Criando planos](#criando-planos)
  - [Retornando planos](#retornando-planos)
  - [Retornando um plano](#retornando-um-plano)
  - [Atualizando um plano](#atualizando-um-plano)
- [Assinaturas](#assinaturas)
  - [Criando assinaturas](#criando-assinaturas)
  - [Split com assinatura](#split-com-assinatura)
  - [Retornando uma assinatura](#retornando-uma-assinatura)
  - [Retornando assinaturas](#retornando-assinaturas)
  - [Atualizando uma assinatura](#atualizando-uma-assinatura)
  - [Cancelando uma assinatura](#cancelando-uma-assinatura)
  - [Transações de assinatura](#transações-de-assinatura)
  - [Pulando cobranças](#pulando-cobranças)
- [Postbacks](#postbacks)
  - [Retornando postbacks](#retornando-postbacks)
  - [Retornando um postback](#retornando-um-postback)
  - [Reenviando um Postback](#reenviando-um-postback)
- [Saldo do recebedor principal](#saldo-do-recebedor-principal)
- [Operações de saldo](#operações-de-saldo)
  - [Histórico das operações](#histórico-das-operações)
  - [Histórico de uma operação específica](#histórico-de-uma-operação-específica)
- [Recebível](#recebível)
  - [Retornando recebíveis](#retornando-recebíveis)
  - [Retornando um recebível](#retornando-um-recebível)
- [Transferências](#transferências)
  - [Criando uma transferência](#criando-uma-transferência)
  - [Retornando transferências](#retornando-transferências)
  - [Retornando uma transferência](#retornando-uma-transferência)
  - [Cancelando uma transferência](#cancelando-uma-transferência)
- [Antecipações](#antecipações)
  - [Criando uma antecipação](#criando-uma-antecipação)
  - [Obtendo os limites de antecipação](#obtendo-os-limites-de-antecipação)
  - [Confirmando uma antecipação building](#confirmando-uma-antecipação-building)
  - [Cancelando uma antecipação pending](#cancelando-uma-antecipação-pending)
  - [Deletando uma antecipação building](#deletando-uma-antecipação-building)
  - [Retornando antecipações](#retornando-antecipações)
- [Contas bancárias](#contas-bancárias)
  - [Criando uma conta bancária](#criando-uma-conta-bancária)
  - [Retornando uma conta bancária](#retornando-uma-conta-bancária)
  - [Retornando contas bancárias](#retornando-contas-bancárias)
- [Recebedores](#recebedores)
  - [Criando um recebedor](#criando-um-recebedor)
  - [Retornando recebedores](#retornando-recebedores)
  - [Retornando um recebedor](#retornando-um-recebedor)
  - [Atualizando um recebedor](#atualizando-um-recebedor)
  - [Saldo de um recebedor](#saldo-de-um-recebedor)
  - [Operações de saldo de um recebedor](#operações-de-saldo-de-um-recebedor)
  - [Operação de saldo específica de um recebedor](#operação-de-saldo-específica-de-um-recebedor)
- [Clientes](#clientes)
  - [Criando um cliente](#criando-um-cliente)
  - [Retornando clientes](#retornando-clientes)
  - [Retornando um cliente](#retornando-um-cliente)
- [Links de pagamento](#links-de-pagamento)
  - [Criando um link de pagamento](#criando-um-link-de-pagamento)
  - [Retornando links de pagamento](#retornando-links-de-pagamento)
  - [Retornando um link de pagamento](#retornando-um-link-de-pagamento)
  - [Cancelando um link de pagamento](#cancelando-um-link-de-pagamento)

## Instalação

Instale a biblioteca utilizando o comando

`composer require pagarme/pagarme-php`

## Configuração

Para incluir a biblioteca em seu projeto, basta fazer o seguinte:

```php
<?php
require('vendor/autoload.php');

$pagarme = new PagarMe\Client('SUA_CHAVE_DE_API');
```

### Definindo headers customizados

1. Se necessário for é possível definir headers http customizados para os requests. Para isso basta informá-los durante a instanciação do objeto `Client`:

```php
<?php
require('vendor/autoload.php');

$pagarme = new PagarMe\Client(
    'SUA_CHAVE_DE_API',
    ['headers' => ['MEU_HEADER_CUSTOMIZADO' => 'VALOR HEADER CUSTOMIZADO']]
); 
```

E então, você pode poderá utilizar o cliente para fazer requisições ao Pagar.me, como nos exemplos abaixo.

## Transações

Nesta seção será explicado como utilizar transações no Pagar.me com essa biblioteca.

### Criando uma transação

```php
<?php
$transaction = $pagarme->transactions()->create([
    'amount' => 1000,
    'payment_method' => 'credit_card',
    'card_holder_name' => 'Anakin Skywalker',
    'card_cvv' => '123',
    'card_number' => '4242424242424242',
    'card_expiration_date' => '1220',
    'customer' => [
        'external_id' => '1',
        'name' => 'Nome do cliente',
        'type' => 'individual',
        'country' => 'br',
        'documents' => [
          [
            'type' => 'cpf',
            'number' => '00000000000'
          ]
        ],
        'phone_numbers' => [ '+551199999999' ],
        'email' => 'cliente@email.com'
    ],
    'billing' => [
        'name' => 'Nome do pagador',
        'address' => [
          'country' => 'br',
          'street' => 'Avenida Brigadeiro Faria Lima',
          'street_number' => '1811',
          'state' => 'sp',
          'city' => 'Sao Paulo',
          'neighborhood' => 'Jardim Paulistano',
          'zipcode' => '01451001'
        ]
    ],
    'shipping' => [
        'name' => 'Nome de quem receberá o produto',
        'fee' => 1020,
        'delivery_date' => '2018-09-22',
        'expedited' => false,
        'address' => [
          'country' => 'br',
          'street' => 'Avenida Brigadeiro Faria Lima',
          'street_number' => '1811',
          'state' => 'sp',
          'city' => 'Sao Paulo',
          'neighborhood' => 'Jardim Paulistano',
          'zipcode' => '01451001'
        ]
    ],
    'items' => [
        [
          'id' => '1',
          'title' => 'R2D2',
          'unit_price' => 300,
          'quantity' => 1,
          'tangible' => true
        ],
        [
          'id' => '2',
          'title' => 'C-3PO',
          'unit_price' => 700,
          'quantity' => 1,
          'tangible' => true
        ]
    ]
]);
```

### Capturando uma transação

```php
<?php
$capturedTransaction = $pagarme->transactions()->capture([
    'id' => 'ID_OU_TOKEN_DA_TRANSAÇÃO',
    'amount' => VALOR_TOTAL_COM_CENTAVOS
]);
```

### Estornando uma transação

```php
<?php
$refundedTransaction = $pagarme->transactions()->refund([
    'id' => 'ID_OU_TOKEN_DA_TRANSAÇÃO',
]);
```

Esta funcionalidade também funciona com estornos parciais, ou estornos com split. Por exemplo:

#### Estornando uma transação parcialmente

```php
<?php
$partialRefundedTransaction = $pagarme->transactions()->refund([
    'id' => 'ID_OU_TOKEN_DA_TRANSAÇÃO',
    'amount' => 'VALOR_PARCIAL_DO_ESTORNO',
]);
```

#### Estornando uma transação com split

```php
<?php
$refundedTransactionWithSplit = $pagarme->transactions()->refund([
    'id' => 'ID_OU_TOKEN_DA_TRANSAÇÃO',
    'amount' => '6153',
    'split_rules' => [
        [
            'id' => 'sr_cj41w9m4d01ta316d02edaqav',
            'amount' => '3000',
            'recipient_id' => 're_cj2wd5ul500d4946do7qtjrvk'
        ],
        [
            'id' => 'sr_cj41w9m4e01tb316dl2f2veyz',
            'amount' => '3153',
            'recipient_id' => 're_cj2wd5u2600fecw6eytgcbkd0',
            'charge_processing_fee' => 'true'
        ]
    ]
]);
```

### Retornando transações

```php
<?php
$transactions = $pagarme->transactions()->getList();
```

Se necessário, você pode utilizar parâmetros para filtrar essa busca, por exemplo, se quiser filtrar apenas transações pagas, você pode utilizar o código abaixo:

```php
<?php
$paidTransactions = $pagarme->transactions()->getList([
    'status' => 'paid'
]);
```

### Retornando uma transação

```php
<?php
$transactions = $pagarme->transactions()->get([
    'id' => 'ID_DA_TRANSAÇÃO' 
]);
```

### Retornando recebíveis de uma transação

```php
<?php
$transactionPayables = $pagarme->transactions()->listPayables([
    'id' => 'ID_DA_TRANSAÇÃO'
]);
```

### Retornando um recebível de uma transação

```php
<?php
$transactionPayable = $pagarme->transactions()->getPayable([
    'transaction_id' => 'ID_DA_TRANSAÇÃO',
    'payable_id' => 'ID_DO_PAYABLE'
]);
```

### Retornando o histórico de operações de uma transação

```php
<?php
$transactionOperations = $pagarme->transactions()->listOperations([
    'id' => 'ID_DA_TRANSAÇÃO',
]);
```

### Notificando cliente sobre boleto a ser pago

```php
<?php
$transactionPaymentNotify = $pagarme->transactions()->collectPayment([
    'id' => 'ID_DA_TRANSAÇÃO',
    'email' = > 'cliente@email.com'
]);
```

### Retornando eventos de uma transação

```php
<?php
$transactionEvents = $pagarme->transactions()->events([
    'id' => 4262049,
]);
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

valorTotal = valorDaTransacao * ( 1 + ( taxaDeJuros * numeroDeParcelas ) / 100 )

Então, utilizando os valores acima, na quinta parcela, a conta ficaria dessa maneira:

valorTotal = 1000 * (1 + (3 * 5) / 100)

Então, o valor a ser pago na quinta parcela seria de 15% da compra, totalizando 1150.

Você pode usar o código abaixo caso queira utilizar essa rota:

```php
<?php
$calculateInstallments = $pagarme->transactions()->calculateInstallments([
    'amount' => 'VALOR_DA_TRANSAÇÃO_EM_CENTAVOS',
    'free_installments' => 'PARCELAS_SEM_JUROS',
    'max_installments' => 'MÁXIMO_DE_PARCELAS',
    'interest_rate' => 'TAXA_DE_JUROS_AO_MÊS'
]);
```

### Testando pagamento de boletos

```php
<?php
$paidBoleto = $pagarme->transactions()->simulateStatus([
    'id' => 'ID_DA_TRANSAÇÃO',
    'status' => 'paid'
]);
```

## Estornos

É possível visualizar todos os estornos que ocorreram em sua conta, basta utilizar o código abaixo:

```php
<?php
$refunds = $pagarme->refunds()->getList();
```

Se preferir, você pode utilizar filtros para trazer apenas o estorno de uma transação em específico, por exemplo:

```php
<?php
$transactionRefunds = $pagarme->refunds()->getList([
    'transaction_id' => 'ID_DA_TRANSAÇÃO_ESTORNADA'
]);
```

## Chargebacks

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
$card = $pagarme->cards()->create([
    'holder_name' => 'Yoda',
    'number' => '4242424242424242',
    'expiration_date' => '1225',
    'cvv' => '123'
]);
```

### Retornando cartões

```php
<?php
$cards = $pagarme->cards()->getList();
```

Se necessário, você pode filtrar por algum dado específico do cartão, por exemplo, o código abaixo irá trazer todos os cartões da bandeira *visa*:

```php
<?php
$visaCards = $pagarme->cards()->getList([
    'brand' => 'visa'
]);
```

### Retornando um cartão

```php
<?php
$card = $pagarme->cards()->get([
    'id' => 'ID_DO_CARTÃO'
]);
```

## Planos

Representa uma configuração de recorrência a qual um cliente consegue assinar.
É a entidade que define o preço, nome e periodicidade da recorrência

### Criando planos

```php
<?php
$plan = $pagarme->plans()->create([
    'amount' => '15000',
    'days' => '30',
    'name' => 'The Pro Plan - Platinum - Best ever'
]);
```

### Retornando planos

```php
<?php
$plans = $pagarme->plans()->getList();
```

### Retornando um plano

```php
<?php
$plan = $pagarme->plans()->get(['id' => '123456']);
```

### Atualizando um plano

```php
<?php
$updatedPlan = $pagarme->plans()->update([
    'id' => '365403',
    'name' => 'The Pro Plan - Susan',
    'trial_days' => '7',
]);
```

## Assinaturas

### Criando assinaturas

```php
<?php
$substription = $pagarme->subscriptions()->create([
    'plan_id' => 123456,
    'payment_method' => 'credit_card',
    'card_number' => '4111111111111111',
    'card_holder_name' => 'UNIX TIME',
    'card_expiration_date' => '0722',
    'card_cvv' => '123',
    'postback_url' => 'http://postbacj.url',
    'customer' => [
        'email' => 'time@unix.com',
        'name' => 'Unix Time',
        'document_number' => '75948706036',
        'address' => [
            'street' => 'Rua de Teste',
            'street_number' => '100',
            'complementary' => 'Apto 666',
            'neighborhood' => 'Bairro de Teste',
            'zipcode' => '11111111'
        ],
        'phone' => [
            'ddd' => '01',
            'number' => '923456780'
        ],
        'sex' => 'other',
        'born_at' => '1970-01-01',
    ],
    'metadata' => [
        'foo' => 'bar'
    ]
]);
```

**Criando assinaturas utilizando _card_id_**

```php
<?php
// Criando o cartão
$card = $pagarme->cards()->create([
    'holder_name' => 'Yoda',
    'number' => '4242424242424242',
    'expiration_date' => '1225',
    'cvv' => '123'
]);

$substription = $pagarme->subscriptions()->create([
    'plan_id' => 365403,
    'card_id' => $card->id,
    'payment_method' => 'credit_card',
    'postback_url' => 'http://www.pudim.com.br',
    'customer' => [
        'email' => 'time@unix.com',
        'name' => 'Unix Time',
        'document_number' => '75948706036',
        'address' => [
            'street' => 'Rua de Teste',
            'street_number' => '100',
            'complementary' => 'Apto 666',
            'neighborhood' => 'Bairro de Teste',
            'zipcode' => '88370801'
        ],
        'phone' => [
            'ddd' => '01',
            'number' => '923456780'
        ],
        'sex' => 'other',
        'born_at' => '1970-01-01',
    ],
    'metadata' => [
        'foo' => 'bar'
    ]
]);

```

### Split com assinatura

```php
<?php
$substription = $pagarme->subscriptions()->create([
    'plan_id' => 123456,
    'card_id' => 'card_abc123456',
    'payment_method' => 'credit_card',
    'postback_url' => 'http://www.pudim.com.br',
    'customer' => [
        'email' => 'time@unix.com',
        'name' => 'Unix Time',
        'document_number' => '75948706036',
        'address' => [
            'street' => 'Rua de Teste',
            'street_number' => '100',
            'complementary' => 'Apto 666',
            'neighborhood' => 'Bairro de Teste',
            'zipcode' => '88370801'
        ],
        'phone' => [
            'ddd' => '01',
            'number' => '923456780'
        ],
        'sex' => 'other',
        'born_at' => '1970-01-01',
    ],
    'amount' => 10000,
    'split_rules' => [
        [
            'recipient_id' => 're_abc1234abc1234abc1234abc1',
            'percentage' => 20,
            'liable' => true,
            'charge_processing_fee' => true,
        ],
        [
            'recipient_id' => 're_abc1234abc1234abc1234abc1',
            'percentage' => 80,
            'liable' => true,
            'charge_processing_fee' => true,
        ]
    ],
    'metadata' => [
        'foo' => 'bar'
    ]
]);
```

### Retornando uma assinatura

```php
<?php
$substription = $pagarme->subscriptions()->get([
    'id' => 123456
]);
```

### Retornando assinaturas

```php
<?php
$substription = $pagarme->subscriptions()->getList();
```

Se necessário, você pode aplicar filtros em sua busca. Por exemplo, se quiser trazer todas as assinatura de um certo plano, você pode utilizar o código abaixo:

```php
<?php
$planSubstriptions = $pagarme->subscriptions()->getList([
    'plan_id' => 'ID_DO_PLANO'
]);
```

### Atualizando uma assinatura

```php
<?php
$updatedSubscription = $pagarme->subscriptions()->update([
    'id' => 1234,
    'plan_id' => 4321,
    'payment_method' => 'boleto'
]);
```

### Cancelando uma assinatura

```php
<?php
$canceledSubscription = $pagarme->subscriptions()->cancel([
    'id' => 12345
]);
```

### Transações de assinatura
```php
<?php
$substriptionTransactions = $pagarme->subscriptions()->transactions([
    'subscription_id' => 1245
]);
```

### Pulando cobranças

```php
<?php
$settledCharges = $pagarme->subscriptions()->settleCharges([
    'id' => 12345,
    'charges' => 5
]);
```

## Postbacks

Ao criar uma transação ou uma assinatura você tem a opção de passar o parâmetro postback_url na requisição. Essa é uma URL do seu sistema que irá então receber notificações a cada alteração de status dessas transações/assinaturas.

Para obter informações sobre postbacks, 3 informações serão necessárias, sendo elas: `model`, `model_id` e `postback_id`.

`model`: Se refere ao objeto que gerou aquele POSTback. Pode ser preenchido com o valor `transaction` ou `subscription`.

`model_id`: Se refere ao ID do objeto que gerou ao POSTback, ou seja, é o ID da transação ou assinatura que você quer acessar os POSTbacks.

`postback_id`: Se refere à notificação específica. Para cada mudança de status de uma assinatura ou transação, é gerado um POSTback. Cada POSTback pode ter várias tentativas de entregas, que podem ser identificadas pelo campo `deliveries`, e o ID dessas tentativas possui o prefixo `pd_`. O campo que deve ser enviado neste parâmetro é o ID do POSTback, que deve ser identificado pelo prefixo `po_`. 

### Retornando postbacks

```php
<?php
$postbacks = $pagarme->postbacks()->getList([
    'model' => 'subscription',
    'model_id' => 'ID_DA_ASSINATURA'
]);
```

### Retornando um postback

```php
<?php
$postback = $pagarme->postbacks()->get([
    'model' => 'transaction',
    'model_id' => 'ID_DA_TRANSAÇÃO',
    'postback_id' => 'po_cjlzhftd2006xg573fwelfg9y'
]);

```
### Reenviando um postback

```php
<?php
$postbackRedeliver = $pagarme->postbacks()->redeliver([
    'model' => 'subscription',
    'model_id' => 'ID_DA_ASSINATURA',
    'postback_id' => 'po_cjlzhftd2006xg573fwelfg9y'
]);
```

### Validando uma requisição de postback

```php
<?php
$postbackPayload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
$postbackIsValid = $pagarme->postbacks()->validate($postbackPayload, $signature);
```

Observação: o código acima serve somente de exemplo para que o processo de validação funcione. Recomendamos que utilize ferramentas fornecidas por bibliotecas ou frameworks para recuperar estas informações de maneira mais adequada.

## Saldo do recebedor principal

Para saber o saldo de sua conta, você pode utilizar esse código:

```php
<?php
$balance = $pagarme->balances()->get();
```

## Operações de saldo

Com este objeto você pode acompanhar todas as movimentações financeiras ocorridas em sua conta Pagar.me.

### Histórico das operações

```php
<?php
$balanceOperations = $pagarme->balanceOperations()->getList();
```

Se necessário, você pode passar filtros como parâmetro, por exemplo:

```php
<?php
$balanceOperations = $pagarme->balanceOperations()->getList([
    'status' => 'available'
]);
```


### Histórico de uma operação específica

```php
<?php
$balanceOperation = $pagarme->balanceOperations()->get([
    'id' => 'BALANCE_OPERATION_ID'
]);
```
## Recebível

Objeto contendo os dados de um recebível. O recebível (payable) é gerado automaticamente após uma transação ser paga. Para cada parcela de uma transação é gerado um recebível, que também pode ser dividido por recebedor (no caso de um split ter sido feito).

### Retornando recebíveis

```php
<?php
$payables = $pagarme->payables()->getList();
```

Se necessário, você pode aplicar filtros na busca dos payables, por exemplo, você pode recuperar todos os payables de uma transação:

```php
<?php
$transactionPayables = $pagarme->payables()->getList([
    'transaction_id' => 'ID_DA_TRANSAÇÃO'
]);
```

### Retornando um recebível

```php
<?php
$payable = $pagarme->payables()->get([
    'id' => 'ID_DO_PAYABLE'
]);
```

## Transferências
Transferências representam os saques de sua conta.

### Criando uma transferência
```php
<?php
$transfer = $pagarme->transfers()->create([
    'amount' => 1000,
    'recipient_id' => 're_cjeptpdyg03u3cb6elj68p5ej'
]);
```

### Retornando transferências

```php
<?php
$transfers = $pagarme->transfers()->getList();
```

Se necessário, você pode aplicar filtros em sua busca, por exemplo:

```php
<?php
$recipientTransfers = $pagarme->transfers()->getList([
    'recipient_id' => 'ID_DO_RECEBEDOR'
]);
```

### Retornando uma transferência

```php
<?php
$transfer = $pagarme->transfers()->get([
    'id' => 'ID_DA_TRANSFERÊNCIA'
]);
```

### Cancelando uma transferência

```php
<?php
$canceledTransfer = $pagarme->transfers()->cancel([
    'id' => 'ID_DA_TRANSFERÊNCIA'
]);
```

## Antecipações

Para entender o que são as antecipações, você deve acessar esse [link](https://docs.pagar.me/docs/overview-antecipacao).

### Criando uma antecipação

```php
<?php
$anticipation = $pagarme->bulkAnticipations()->create([
    'recipient_id' => 're_cjeptpdyg03u3cb6elj68p5ej',
    'build' => 'true',
    'payment_date' => '1536883200000',
    'requested_amount' => '300000',
    'timeframe' => 'start'
]);
```

### Obtendo os limites de antecipação

```php
<?php
$anticipationLimits = $pagarme->bulkAnticipations()->getLimits([
    'recipient_id' => 'ID_DO_RECEBEDOR',
    'payment_date' => '1536883200000',
    'timeframe' => 'start'
]);
```

### Confirmando uma antecipação building

```php
<?php
$confirmedAnticipation = $pagarme->bulkAnticipations()->confirm([
    'recipient_id' => 'ID_DO_RECEBEDOR',
    'bulk_anticipation_id' => 'ID_DA_ANTECIPAÇÃO',
]);
```

### Cancelando uma antecipação pending

```php
<?php
$canceledAnticipation = $pagarme->bulkAnticipations()->cancel([
    'recipient_id' => 'ID_DO_RECEBEDOR',
    'bulk_anticipation_id' => 'ID_DA_ANTECIPAÇÃO',
]);
```

### Deletando uma antecipação building

```php
<?php
$deletedAnticipation = $pagarme->bulkAnticipations()->delete([
    'recipient_id' => 'ID_DO_RECEBEDOR',
    'bulk_anticipation_id' => 'ID_DA_ANTECIPAÇÃO',
]);
```

### Retornando antecipações

```php
<?php
$anticipations = $pagarme->bulkAnticipations()->getList([
    'recipient_id' => 'ID_DO_RECEBEDOR'
]);
```

Se necessário, você pode aplicar filtros nessa busca, por exemplo, pelo valor antecipado:

```php
<?php
$anticipations = $pagarme->bulkAnticipations()->getList([
    'recipient_id' => 'ID_DO_RECEBEDOR',
    'amount' => 'VALOR_ANTECIPADO'
]);
```

## Contas bancárias

Contas bancárias identificam para onde será enviado o dinheiro de futuros pagamentos.

### Criando uma conta bancária

```php
<?php
$bankAccount = $pagarme->bankAccounts()->create([
    'bank_code' => '341',
    'agencia' => '0932',
    'agencia_dv' => '5',
    'conta' => '58054',
    'conta_dv' => '1',
    'document_number' => '26268738888',
    'legal_name' => 'API BANK ACCOUNT'
]);
```

### Retornando uma conta bancária

```php
<?php
$bankAccount = $pagarme->bankAccounts()->get([
    'id' => 'ID_DA_CONTA_BANCÁRIA'
]);
```

### Retornando contas bancárias

```php
<?php
$bankAccounts = $pagarme->bankAccounts()->getList();
```

Se quiser, você pode aplicar filtros para a busca de contas bancárias, como por exemplo, filtrar pelo código do banco:

```php
<?php
$bankAccounts = $pagarme->bankAccounts()->getList([
    'bank_code' => '341'
]);
```

## Recebedores

Para dividir uma transação entre várias entidades, é necessário ter um recebedor para cada uma dessas entidades. Recebedores contém informações da conta bancária para onde o dinheiro será enviado, e possuem outras informações para saber quanto pode ser antecipado por ele, ou quando o dinheiro de sua conta será sacado automaticamente.

### Criando um recebedor

```php
<?php
$recipient = $pagarme->recipients()->create([
    'anticipatable_volume_percentage' => '85', 
    'automatic_anticipation_enabled' => 'true', 
    'bank_account_id' => '17899179', 
    'transfer_day' => '5', 
    'transfer_enabled' => 'true', 
    'transfer_interval' => 'weekly'
]);
```

### Retornando recebedores

```php
<?php
$recipients = $pagarme->recipients()->getList();
```

Se necessário, você pode aplicar filtros nessa busca. Por exemplo, se quiser retornar todos os recebedores, com transferência habilitada, você pode utilizar esse código:

```php
<?php
$transferEnabledRecipients = $pagarme->recipients()->getList([
    'transfer_enabled' => true
]);
```

### Retornando um recebedor

```php
<?php
$recipient = $pagarme->recipients()->get([
    'id' => 'ID_DO_RECEBEDOR'
]);

```

### Atualizando um recebedor

```php
<?php
$updatedRecipient = $pagarme->recipients()->update([
    'id' => 'ID_DO_RECEBEDOR',
    'anticipatable_volume_percentage' => 80,
    'transfer_day' => 4
]);
```

### Saldo de um recebedor

```php
<?php
$recipientBalance = $pagarme->recipients()->getBalance([
    'recipient_id' => 'ID_DO_RECEBEDOR',
]);
```

### Operações de saldo de um recebedor

```php
<?php
$recipientBalanceOperations = $pagarme->recipients()->listBalanceOperation([
    'recipient_id' => 'ID_DO_RECEBEDOR'
]);
```

### Operação de saldo específica de um recebedor

```php
<?php
$recipientBalanceOperation = $pagarme->recipients()->getBalanceOperation([
    'recipient_id' => 'ID_DO_RECEBEDOR',
    'balance_operation_id' => 'ID_DA_OPERAÇÃO'
]);
```

## Clientes

Clientes representam os usuários de sua loja, ou negócio. Este objeto contém informações sobre eles, como nome, e-mail e telefone, além de outros campos.

### Criando um cliente

```php
<?php
$customer = $pagarme->customers()->create([
    'external_id' => '#123456789',
    'name' => 'João das Neves',
    'type' => 'individual',
    'country' => 'br',
    'email' => 'joaoneves@norte.com',
    'documents' => [
      [
        'type' => 'cpf',
        'number' => '11111111111'
      ]
    ],
    'phone_numbers' => [
      '+5511999999999',
      '+5511888888888'
    ],
    'birthday' => '1985-01-01'
]);
```
### Retornando clientes

```php
<?php
$customers = $pagarme->customers()->getList();
```

### Retornando um cliente

```php
<?php
$customer = $pagarme->customers()->get([
    'id' => 'ID_DO_CLIENTE'
]);
```

## Links de pagamento

### Criando um link de pagamento

```php
<?php
$paymentLink = $pagarme->paymentLinks()->create([
    'amount' => 10000,
    'items' => [
        [
            'id' => '1',
            'title' => "Fighter's Sword",
            'unit_price' => 4000,
            'quantity' => 1,
            'tangible' => true,
            'category' => 'weapon',
            'venue' => 'A Link To The Past',
            'date' => '1991-11-21'
        ],
        [
            'id' => '2',
            'title' => 'Kokiri Sword',
            'unit_price' => 6000,
            'quantity' => 1,
            'tangible' => true,
            'category' => 'weapon',
            'venue' => "Majora's Mask",
            'date' => '2000-04-27'
        ],
    ],
    'payment_config' => [
        'boleto' => [
            'enabled' => true,
            'expires_in' => 20
        ],
        'credit_card' => [
            'enabled' => true,
            'free_installments' => 4,
            'interest_rate' => 25,
            'max_installments' => 12
        ],
        'default_payment_method' => 'boleto'
    ],
    'max_orders' => 1,
    'expires_in' => 60
]);
```

### Retornando links de pagamento

```php
<?php
$paymentLinks = $pagarme->paymentLinks()->getList();
```

### Retornando um link de pagamento

```php
<?php
$paymentLink = $pagarme->paymentLinks()->get([
    'id' => 'ID_DO_LINK_DE_PAGAMENTO'
]);
```

### Cancelando um link de pagamento

```php
<?php
$canceledPaymentLink = $pagarme->paymentLinks()->cancel([
    'id' => 'ID_DO_LINK_DE_PAGAMENTO'
]);
```
