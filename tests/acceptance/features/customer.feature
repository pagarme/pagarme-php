Feature: Customer
 Como cliente da Pagar.me integrando uma aplicação PHP
 Eu quero uma camada de abstração
 Para que eu possa gerenciar meus clientes

  Scenario: Registering customers
    Given customer data
    When register this data
    Then an customer must be created

  Scenario: Getting customers
    Given customer data
    When register this data
    Then the customer must be retrievable
