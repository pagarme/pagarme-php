<?php

class PlanTest extends PagarMeTestCase
{
    public function testCreate()
    {
        $plan = self::createTestPlan();
        $plan->create();
        $this->assertTrue($plan->getId());
    }

    public function testUpdate()
    {
        $plan = self::createTestPlan();
        $plan->create();
        $this->assertEqual($plan->getName(), "Plano Silver");
        $plan->setName("Plano gold!");
        $plan->save();
        $plan2 = Pagarme\Plan::findById($plan->getId());        
        $this->assertEqual($plan->getName(), $plan2->getName());

        $this->expectException(new IsAExpectation('Pagarme\Exception'));
        $plan2->setDays('60');
        $plan2->save();
    } 

    public function testUpdatePaymentMethods()
    {
        $plan = self::createTestPlan();    
        $plan->create();
        $this->assertTrue(in_array('credit_card', $plan->getPaymentMethods()));
        $this->assertTrue(in_array('boleto', $plan->getPaymentMethods()));

        $plan2 = self::createTestPlan();
        $plan2->setPaymentMethods(array('credit_card'));

        $this->assertTrue(in_array('credit_card', $plan2->getPaymentMethods()));
        $this->assertFalse(in_array('boleto', $plan2->getPaymentMethods()));
    }

    public function testValidate()
    {
        $plan = new Pagarme\Plan();

        $this->expectException(new IsAExpectation('Pagarme\Exception'));
        $plan->setAmount('0');
        $plan->create();
        $plan->setAmount('10000');

        $this->expectException(new IsAExpectation('Pagarme\Exception'));
        $plan->days('0');
        $plan->create();
        $plan->setDays('30');

        $this->expectException(new IsAExpectation('Pagarme\Exception'));
        $plan->setTrialDays('-1');
        $plan->create();
        $plan->setTrialDays("10");

        $this->expectException(new IsAExpectation('Pagarme\Exception'));
        $plan->setName('');
        $plan->create();
        $plan->setName('Plan');

        $plan->create();

        $plan->assertTrue($plan->getId());
    }
}