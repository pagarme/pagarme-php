Feature: Subscription
 Como cliente da Pagar.me integrando uma aplicação PHP
 Eu quero uma camada de abstração
 Para que eu possa realizar assinaturas

  Scenario: Create a subscription
    Given a valid customer
    And a valid plan
    And a valid card
    When make a credit card subscription
    Then a subscription must be created
    And the payment method must be 'credit_card'

  Scenario: Create a boleto subscription
    Given a valid customer
    And a valid plan
    When make a boleto subscription
    Then a subscription must be created
    And the payment method must be 'boleto'

 Scenario: Get a subscription
    Given a previous created subscription
    When I query for the subscription
    Then the same subscription must be returned

 Scenario: List subscriptions
    Given previous created subscriptions
    When I query for subscriptions
    Then subscriptions must be returned

 Scenario: Cancel subscription
    Given a previous created subscription
    When I cancel the subscription
    Then subscription status must be 'canceled'

 Scenario: List subscription transacitons
    Given a previous created subscription
    When I query the transactions of this subscription
    Then transactions must be returned

 Scenario: Update the plan of the subscription
    Given previous created subscriptions
    When I update the subscription to use plan name 'Gold Plan'
    Then the same subscription must be returned
    And must contain 'Gold Plan' in 'Plan'

 Scenario: Update the card of the subscription
    Given a previous created credit card subscription
    When I update the subscription to use card number '5433553684826195'
    Then the same subscription must be returned 
    And must contain '543355' in 'Card'

 Scenario: Update the payment method of the subscription
    Given previous created subscriptions
    When I update the subscription to use payment method 'boleto'
    Then the same subscription must be returned
    And must contain 'boleto' in 'PaymentMethod'

 Scenario: Update the subscription to card instead of boleto
    Given previous created subscriptions
    When I update the subscription to use card number '5433553684826195'
    Then the same subscription must be returned
    And must contain '543355' in 'Card'

 Scenario: Update the subscription payment method, card and plan together
    Given previous created subscriptions
    When I update the subscription to use card number '5433553684826195'
    And I update the subscription to use plan name 'Gold Plan'
    Then the same subscription must be returned
    And must contain '543355' in 'Card'
    And must contain 'Gold Plan' in 'Plan'
    And must contain 'credit_card' in 'PaymentMethod'
