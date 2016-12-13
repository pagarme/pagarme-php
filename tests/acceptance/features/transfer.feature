Feature: Transfer
 Como cliente da Pagar.me integrando uma aplicação PHP
 Eu quero uma camada de abstração
 Para que eu possa realizar transferencias

  Scenario: Create a transfer with a recipient
    Given a valid recipient
    And avaliable founds
    When make tranfer with amount of "5000"
    Then a transfer must be created
    And amount must be the same

  Scenario: Create a transfer with a recipient and custom bank account
    Given a valid recipient
    And avaliable founds
    When make tranfer with amount of "5000" to specific bank account
    Then a transfer must be created
    And amount must be the same
