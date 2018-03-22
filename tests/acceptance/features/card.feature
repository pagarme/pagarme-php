Feature: Cards
  Como cliente da Pagar.me integrando uma aplicação PHP
  Eu quero uma camada de abstração
  Para que eu possa gerenciar cartoes de crédito

  Scenario Outline: Registering credit cards
    Given a card with "<number>", "<holder>", "<expiration>" and "<cvv>"
    When register the card
    Then should have a card starting with "<start>", ending with "<end>", and has "<expiration>"
    And the card must be valid
    Examples:
      |       number        |     holder    | expiration | cvv |  start | end  |
      |  4485546331016988   |  João Silva   |    0623    | 123 | 448554 | 6988 |
      |  5474098940693468   |  Maria Silva  |    0623    | 123 | 547409 | 3468 |
      |  30169926530004     |  Pedro Silva  |    0623    | 123 | 301699 | 0004 |
      |  376660303489147    |  Cesar Silva  |    0623    | 123 | 376660 | 9147 |
      |  6062824855595083   |  Carla Silva  |    0623    | 123 | 606282 | 5083 |
      |  6363688420875031   |  Marta Silva  |    0623    | 123 | 636368 | 5031 |

  Scenario Outline: Registering credit cards
    Given a card with "<number>", "<holder>", "<expiration>" and "<cvv>"
    When register the card
    And query for the card
    Then should have the same card
    And the card must be valid
    Examples:
      |       number        |     holder    | expiration | cvv |
      |  4929321265858746   |  João Silva   |    0623    | 123 |
      |  5432256307060520   |  Maria Silva  |    0623    | 123 |
      |  30368598412349     |  Pedro Silva  |    0623    | 123 |
      |  346352677988113    |  Cesar Silva  |    0623    | 123 |
      |  6062825718578307   |  Carla Silva  |    0623    | 123 |
      |  4514164846540487   |  Marta Silva  |    0623    | 123 |
