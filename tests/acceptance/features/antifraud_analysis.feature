Feature: Antifraud Analysis
 Como cliente da Pagar.me integrando uma aplicação PHP
 Eu quero uma camada de abstração
 Para que eu detalhar análises de antifraude

  Scenario: Query antifraud analysis
    Given a previous created transaction
    When I query transaction antifraud analysis
    Then a array of Antifraud Analyses must be returned
