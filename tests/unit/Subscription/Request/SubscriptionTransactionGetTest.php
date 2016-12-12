<?php

namespace PagarMe\SdkTest\Subscription\Request;

use PagarMe\Sdk\Subscription\Request\SubscriptionTransactionsGet;

class SubscriptionTransactionsGetTest extends \PHPUnit_Framework_TestCase
{
    const METHOD          = 'GET';
    const PATH            = 'subscriptions/123/transactions';
    const SUBSCRIPTION_ID = 123;

    /**
     * @test
    **/
    public function mustPayloadBeCorrect()
    {
        $subscriptionMock = $this->getMockBuilder('PagarMe\Sdk\Subscription\Subscription')
            ->disableOriginalConstructor()
            ->getMock();
        $subscriptionMock->method('getId')->willReturn(self::SUBSCRIPTION_ID);

        $subscriptionCancelRequest = new SubscriptionTransactionsGet($subscriptionMock);

        $this->assertEquals(
            $subscriptionCancelRequest->getPayload(),
            []
        );
    }

    /**
     * @test
    **/
    public function mustMethodBeCorrect()
    {
        $subscriptionMock = $this->getMockBuilder('PagarMe\Sdk\Subscription\Subscription')
            ->disableOriginalConstructor()
            ->getMock();
        $subscriptionMock->method('getId')->willReturn(self::SUBSCRIPTION_ID);

        $subscriptionCancelRequest = new SubscriptionTransactionsGet($subscriptionMock);

        $this->assertEquals(
            $subscriptionCancelRequest->getMethod(),
            self::METHOD
        );
    }

    /**
     * @test
    **/
    public function mustPathBeCorrect()
    {
        $subscriptionMock = $this->getMockBuilder('PagarMe\Sdk\Subscription\Subscription')
            ->disableOriginalConstructor()
            ->getMock();
        $subscriptionMock->method('getId')->willReturn(self::SUBSCRIPTION_ID);

        $subscriptionCancelRequest = new SubscriptionTransactionsGet($subscriptionMock);

        $this->assertEquals(
            $subscriptionCancelRequest->getPath(),
            self::PATH
        );
    }
}
