<?php

namespace PagarMe\Test;

use PagarMe\Routes;
use PHPUnit\Framework\TestCase;

class RoutesTest extends TestCase
{
    /**
     * @param mixed $subject
     */
    public function assertIsCallable($subject)
    {
        $type = gettype($subject);

        self::assertThat(
            is_callable($subject),
            self::isTrue(),
            "Failed asserting that subject of type $type can be called/invoked as a function/method."
        );
    }

    public function testTransactionRoutes()
    {
        $routes = Routes::transactions();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
        $this->assertObjectHasAttribute('capture', $routes);
        $this->assertIsCallable($routes->capture);
        $this->assertobjecthasattribute('refund', $routes);
        $this->assertiscallable($routes->refund);
        $this->assertobjecthasattribute('payables', $routes);
        $this->assertiscallable($routes->payables);
        $this->assertobjecthasattribute('payablesDetails', $routes);
        $this->assertiscallable($routes->payablesDetails);
        $this->assertobjecthasattribute('operations', $routes);
        $this->assertiscallable($routes->operations);
        $this->assertobjecthasattribute('collectPayment', $routes);
        $this->assertiscallable($routes->collectPayment);
        $this->assertobjecthasattribute('events', $routes);
        $this->assertiscallable($routes->events);
        $this->assertobjecthasattribute('calculateInstallments', $routes);
        $this->assertiscallable($routes->calculateInstallments);
    }

    public function testCustomerRoutes()
    {
        $routes = Routes::customers();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
    }

    public function testCardRoutes()
    {
        $routes = Routes::cards();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
    }

    public function testBankAccountRoutes()
    {
        $routes = Routes::bankAccounts();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
    }

    public function testPlansRoutes()
    {
        $routes = Routes::plans();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
    }

    public function testBulkAnticipationsRoutes()
    {
        $routes = Routes::bulkAnticipations();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('limits', $routes);
        $this->assertIsCallable($routes->limits);
        $this->assertObjectHasAttribute('confirm', $routes);
        $this->assertIsCallable($routes->confirm);
        $this->assertObjectHasAttribute('cancel', $routes);
        $this->assertIsCallable($routes->cancel);
        $this->assertObjectHasAttribute('delete', $routes);
    }

    public function testPaymentLinksRoutes()
    {
        $routes = Routes::paymentLinks();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
        $this->assertObjectHasAttribute('cancel', $routes);
        $this->assertIsCallable($routes->cancel);
    }

    public function testTransfersRoutes()
    {
        $routes = Routes::transfers();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
        $this->assertObjectHasAttribute('cancel', $routes);
        $this->assertIsCallable($routes->cancel);
    }

    public function testRecipientRoutes()
    {
        $routes = Routes::recipients();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
        $this->assertObjectHasAttribute('balance', $routes);
        $this->assertIsCallable($routes->balance);
        $this->assertObjectHasAttribute('balanceOperations', $routes);
        $this->assertIsCallable($routes->balanceOperations);
        $this->assertObjectHasAttribute('balanceOperation', $routes);
        $this->assertIsCallable($routes->balanceOperation);
    }

    public function testSubscriptionRoutes()
    {
        $routes = Routes::subscriptions();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
        $this->assertObjectHasAttribute('cancel', $routes);
        $this->assertIsCallable($routes->cancel);
        $this->assertObjectHasAttribute('transactions', $routes);
        $this->assertIsCallable($routes->transactions);
        $this->assertObjectHasAttribute('settleCharges', $routes);
        $this->assertIsCallable($routes->settleCharges);
    }

    public function testRefundsRoute()
    {
        $routes = Routes::refunds();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
    }

    public function testBalanceRoutes()
    {
        $routes = Routes::balances();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
    }

    public function testPostbackRoutes()
    {
        $routes = Routes::postbacks();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
        $this->assertObjectHasAttribute('redeliver', $routes);
        $this->assertIsCallable($routes->redeliver);
    }

    public function testPayableRoutes()
    {
        $routes = Routes::payables();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
    }

    public function testBalanceOperationsRoutes()
    {
        $routes = Routes::balanceOperations();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
    }

    public function testChargebacksRoute()
    {
        $routes = Routes::chargebacks();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
    }
}
