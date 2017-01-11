<?php

namespace PagarMe\SdkTest\Subscription\Request;

use PagarMe\Sdk\Subscription\Request\SubscriptionCancel;
use PagarMe\Sdk\Request;

class SubscriptionCancelTest extends \PHPUnit_Framework_TestCase
{
    const PATH            = 'subscriptions/123/cancel';
    const SUBSCRIPTION_ID = 123;

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $subscriptionMock = $this->getMockBuilder('PagarMe\Sdk\Subscription\Subscription')
            ->disableOriginalConstructor()
            ->getMock();
        $subscriptionMock->method('getId')->willReturn(self::SUBSCRIPTION_ID);
        $subscriptionCancelRequest = new SubscriptionCancel($subscriptionMock);

        $this->assertEquals(
            $subscriptionCancelRequest->getPayload(),
            []
        );
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $subscriptionMock = $this->getMockBuilder('PagarMe\Sdk\Subscription\Subscription')
            ->disableOriginalConstructor()
            ->getMock();
        $subscriptionMock->method('getId')->willReturn(self::SUBSCRIPTION_ID);
        $subscriptionCancelRequest = new SubscriptionCancel($subscriptionMock);

        $this->assertEquals(
            $subscriptionCancelRequest->getMethod(),
            Request::HTTP_POST
        );
    }

    /**
     * @test
     */
    public function mustPathBeCorrect()
    {
        $subscriptionMock = $this->getMockBuilder('PagarMe\Sdk\Subscription\Subscription')
            ->disableOriginalConstructor()
            ->getMock();
        $subscriptionMock->method('getId')->willReturn(self::SUBSCRIPTION_ID);
        $subscriptionCancelRequest = new SubscriptionCancel($subscriptionMock);

        $this->assertEquals(
            $subscriptionCancelRequest->getPath(),
            self::PATH
        );
    }
}
