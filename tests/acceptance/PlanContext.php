<?php

namespace PagarMe\Acceptance;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;

class PlanContext extends BasicContext
{
    private $amount;
    private $days;
    private $name;

    private $trial;
    private $methods;
    private $color;
    private $charges;
    private $installments;

    private $plan;
    private $plans;

    /**
     * @Given a :amount, :days and :name
     */
    public function planMainFields($amount, $days, $name)
    {
        $this->amount = $amount;
        $this->days   = $days;
        $this->name   = $name;
    }

    /**
     * @Given :trial, :methods, :color, :charges, and :installments
     */
    public function planAdditionalFields($trial, $methods, $color, $charges, $installments)
    {
        $this->trial        = null;
        $this->methods      = null;
        $this->color        = null;
        $this->charges      = null;
        $this->installments = null;

        if ($trial != 'null') {
            $this->trial = $trial;
        }

        if ($methods != 'null') {
            $this->methods = explode(',', $methods);
        }

        if ($color != 'null') {
            $this->color = $color;
        }

        if ($charges != 'null') {
            $this->charges = $charges;
        }

        if ($installments != 'null') {
            $this->installments = $installments;
        }
    }

    /**
     * @When register the plan
     */
    public function registerThePlan()
    {
        $this->plan = self::getPagarMe()
            ->plan()
            ->create(
                $this->amount,
                $this->days,
                $this->name,
                $this->trial,
                $this->methods,
                $this->color,
                $this->charges,
                $this->installments
            );
    }

    /**
     * @Then a plan must be created
     */
    public function aPlanMustBeCreated()
    {
        assertInstanceOf(
            'PagarMe\Sdk\Plan\Plan',
            $this->plan
        );
    }

    /**
     * @Then must plan contain same data
     */
    public function mustPlanContainSameData()
    {
        assertEquals($this->amount, $this->plan->getAmount());
        assertEquals($this->days, $this->plan->getDays());
        assertEquals($this->name, $this->plan->getName());
        assertEquals($this->trial, $this->plan->getTrialDays());
        assertEquals(
            $this->defaultPaymentMethods($this->methods),
            $this->plan->getPaymentMethods()
        );
        assertEquals($this->color, $this->plan->getColor());
        assertEquals($this->charges, $this->plan->getCharges());
        assertEquals(
            $this->defaultInstallmets($this->installments),
            $this->plan->getInstallments()
        );
    }

    private function defaultInstallmets($installments)
    {
        if (is_null($installments)) {
            return 1;
        }

        return $installments;
    }

    private function defaultPaymentMethods($methods)
    {
        if (is_null($methods)) {
            return ['boleto', 'credit_card'];
        }

        return $methods;
    }

    /**
     * @Given a previous created plans
     */
    public function aPreviousCreatedPlans()
    {
        for ($i=0; $i < 3; $i++) {
            self::getPagarMe()
                ->plan()
                ->create(
                    rand(1000, 10000),
                    rand(10, 60),
                    uniqid('plan'),
                    null,
                    null,
                    null,
                    null,
                    null
                );
        }
    }

    /**
     * @When i query for plans
     */
    public function iQueryForPlans()
    {
        sleep(1);
        $this->plans = self::getPagarMe()
                ->plan()
                ->getList();
    }

    /**
     * @Then a list of Plans must be returned
     */
    public function aListOfPlansMustBeReturned()
    {
        assertContainsOnly(
            'PagarMe\Sdk\Plan\Plan',
            $this->plans
        );
        assertGreaterThanOrEqual(3, count($this->plans));
    }
}
