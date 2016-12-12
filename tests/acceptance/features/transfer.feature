Feature: Transfer
 Como cliente da Pagar.me integrando uma aplicação PHP
 Eu quero uma camada de abstração
 Para que eu possa realizar transferencias

  Scenario: Create a transfer with a recipient
    Given a valid recipient
    And avaliable founds
    When make transaction with recipient and amount of "5000"
    Then a transfer must be created
    And amount must be the same
