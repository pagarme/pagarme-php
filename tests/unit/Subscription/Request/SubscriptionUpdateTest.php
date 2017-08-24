<?php

namespace PagarMe\SdkTest\Subscription\Request;

use PagarMe\Sdk\Subscription\Request\SubscriptionUpdate;
use PagarMe\Sdk\RequestInterface;

class SubscriptionUpdateTest extends \PHPUnit_Framework_TestCase
{
    const SUBSCRIPTION_ID = 123;
    const CARD_ID     = 'card_123';
    const BOLETO      = 'boleto';
    const CREDIT_CARD = 'credit_card';
    const PLAN_ID     = 'plan_123';

    private $subscriptionUpdateInstance = null;

    public function setUp()
    {
        $subscriptionMock = $this->getMockSubscription();
        $subscriptionMementoMock = $this->getMockSubscription();
        $this->subscriptionUpdateInstance = new SubscriptionUpdate($subscriptionMock, $subscriptionMementoMock);
    }

    public function assertPreconditions()
    {
        $this->assertInstanceOf(
            $name = 'PagarMe\Sdk\Subscription\Request\SubscriptionUpdate',
            $this->subscriptionUpdateInstance,
            "Expected instance of :{$name}");

        $this->assertEquals(
            RequestInterface::HTTP_PUT,
            $this->subscriptionUpdateInstance->getMethod(),
            "The HTTP verb must be :{RequestInterface::HTTP_PUT}"
        );

        $this->assertEquals(
            $path = 'subscriptions/123',
            $this->subscriptionUpdateInstance->getPath(),
            "The URI must be : {$path}"
        );
    }

    /**
    * @dataProvider providerGetPayload
    */
    public function testPayDataIsLoadWithSuccess($subscription, $subscriptionMemento, $expected)
    {
        $this->subscriptionUpdateInstance = new SubscriptionUpdate($subscription, $subscriptionMemento);

        $this->assertEquals($expected, $this->subscriptionUpdateInstance->getPayload());
    }

    public function providerGetPayload()
    {
        $cardNotSupplied = null;
        $cardSupplied = $this->getMockCard(self::CARD_ID);
        $planNotSupplied = $this->getMockPlan();
        $planSupplied = $this->getMockPlan(self::PLAN_ID);

        return [
            'When we have NOTHING to load' => [
                'subscription' => $this->getMockSubscription(),
                'subscriptionMemento'=> $this->getMockSubscription(),
                'expected' =>[]
                ],
            'When we have just one CARD supplied to load' => [
                'subscription' => $this->getMockSubscription($cardSupplied),
                'subscriptionMemento' => $this->getMockSubscription($this->getMockCard(rand())),
                'expected' =>['payment_method' => self::CREDIT_CARD, 'card_id' => self::CARD_ID]
                ],
            'When we have just one PLAN supplied to load' => [
                'subscription' => $this->getMockSubscription($cardNotSupplied, $planSupplied),
                'subscriptionMemento' => $this->getMockSubscription($cardNotSupplied, $this->getMockPlan()),
                'expected' =>['plan_id' => self::PLAN_ID]
                ],
            'When we try load the same PLAN applied previously' => [
                'subscription' => $this->getMockSubscription($cardNotSupplied, $planSupplied),
                'subscriptionMemento' => $this->getMockSubscription($cardNotSupplied, $planSupplied),
                'expected' =>[]
                ],
            'When we have just one PAYMENT METHOD supplied to load' => [
                'subscription' => $this->getMockSubscription($cardNotSupplied, $planNotSupplied, self::BOLETO),
                'subscriptionMemento' => $this->getMockSubscription($cardNotSupplied, $planNotSupplied),
                'expected' =>['payment_method' => self::BOLETO]
                ],
            'When we try load the same PAYMENT METHOD applied previously' => [
                'subscription' => $this->getMockSubscription($cardNotSupplied, $planNotSupplied, self::BOLETO),
                'subscriptionMemento' => $this->getMockSubscription($cardNotSupplied, $planNotSupplied, self::BOLETO),
                'expected' =>[]
                ],
            'When we have all parameters to load' => [
                'subscription' => $this->getMockSubscription($cardSupplied, $planSupplied, self::CREDIT_CARD),
                'subscriptionMemento' => $this->getMockSubscription($cardSupplied, $planNotSupplied, self::BOLETO),
                'expected' =>['card_id' => self::CARD_ID, 'plan_id' => self::PLAN_ID, 'payment_method' => self::CREDIT_CARD]
                ],  
        ];
    }

    public function getMockSubscription($card = null, $plan = null, $paymentMethod = null)
    {
        $subscriptionMock = $this->getMockBuilder('PagarMe\Sdk\Subscription\Subscription')
            ->disableOriginalConstructor()
            ->getMock();
        $subscriptionMock->method('getId')->willReturn(self::SUBSCRIPTION_ID);
        $subscriptionMock->method('getCard')->willReturn($card);
        $subscriptionMock->method('getPlan')->willReturn($plan);
        $subscriptionMock->method('getPaymentMethod')->willReturn($paymentMethod);

        return $subscriptionMock;
    }

    public function getMockPlan($planId = null)
    {
        $planMock = $this->getMockBuilder('PagarMe\Sdk\Plan\Plan')
            ->disableOriginalConstructor()
            ->getMock();
        $planMock->method('getId')->willReturn($planId);

        return $planMock;
    }

    public function getMockCard($cardId = null)
    {
        $cardMock = $this->getMockBuilder('PagarMe\Sdk\Card\Card')
            ->disableOriginalConstructor()
            ->getMock();
        $cardMock->method('getId')->willReturn($cardId);

        return $cardMock;
    }
}
