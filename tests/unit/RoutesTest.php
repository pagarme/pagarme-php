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
        $this->assertObjectHasAttribute('refund', $routes);
        $this->assertIsCallable($routes->refund);
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
}
