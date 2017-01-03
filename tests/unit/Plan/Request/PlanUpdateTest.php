<?php

namespace PagarMe\SdkTest\Request;

use PagarMe\Sdk\Plan\Request\PlanUpdate;

class PlanUpdateTest extends \PHPUnit_Framework_TestCase
{
    const METHOD  = 'PUT';
    const PATH    = 'plans/1406';

    const ID              = 1406;
    const AMOUNT          = 1337;
    const DAYS            = 15;
    const NAME            = "Plano teste";
    const TRIAL_DAYS      = 10;
    const PAYMENT_METHODS = null;
    const COLOR           = 'Silver';
    const CHARGES         = 13;
    const INSTALLMENTS    = 26;

    /**
     * @test
     */
    public function mustContentBeCorrect()
    {
        $planMock = $this->getMockBuilder('PagarMe\Sdk\Plan\Plan')
            ->disableOriginalConstructor()
            ->getMock();

        $planMock->method('getId')->willReturn(self::ID);
        $planMock->method('getAmount')->willReturn(self::AMOUNT);
        $planMock->method('getDays')->willReturn(self::DAYS);
        $planMock->method('getName')->willReturn(self::NAME);
        $planMock->method('getTrialDays')->willReturn(self::TRIAL_DAYS);
        $planMock->method('getPaymentMethods')->willReturn(self::PAYMENT_METHODS);
        $planMock->method('getColor')->willReturn(self::COLOR);
        $planMock->method('getCharges')->willReturn(self::CHARGES);
        $planMock->method('getInstallments')->willReturn(self::INSTALLMENTS);

        $request = new PlanUpdate($planMock);

        $this->assertEquals(self::PATH, $request->getPath());
        $this->assertEquals(self::METHOD, $request->getMethod());
        $this->assertEquals(
            [
                'id'              => self::ID,
                'name'            => self::NAME,
                'trial_days'      => self::TRIAL_DAYS,
                'color'           => self::COLOR,
                'charges'         => self::CHARGES
            ],
            $request->getPayload()
        );
    }
}
