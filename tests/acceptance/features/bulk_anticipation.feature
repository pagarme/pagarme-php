Feature: Bulk Anticipation
 Como cliente da Pagar.me integrando uma aplicação PHP
 Eu quero uma camada de abstração
 Para que eu possa manter antecipações

  Scenario Outline: Creating bulk anticipation
    Given a recipient with anticipatable volume
    And company has paid transaction with "<requested_amount>"
    When register a anticipation with "<payment_date>", "<timeframe>", "<requested_amount>", "<build>"
    Then a anticipation must be created
    And must anticipation contain same data
    Examples:
    | payment_date  | timeframe | requested_amount | build |
    | +5 days       | start     | 1000             | true  |
    | +6 days       | start     | 1000             | false |

  Scenario Outline: Deleting Bulk Anticipation
    Given a recipient with anticipatable volume
    And company has paid transaction with "<requested_amount>"
    When register a anticipation with "<payment_date>", "<timeframe>", "<requested_amount>", "<build>"
    Then a anticipation must be created
    And when I delete the previously created Anticipation
    Then the Anticipation should no longer exist
    Examples:
    | payment_date  | timeframe | requested_amount | build |
    | +5 days       | start     | 1000             | true  |
