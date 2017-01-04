<?php

namespace PagarMe\SdkTest\Subscription\Request;

use PagarMe\Sdk\Subscription\Request\SubscriptionCancel;

class SubscriptionCancelTest extends \PHPUnit_Framework_TestCase
{
    const METHOD          = 'POST';
    const PATH            = 'subscriptions/123/cancel';
    const SUBSCRIPTION_ID = 123;

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $subscriptionCancelRequest = new SubscriptionCancel(self::SUBSCRIPTION_ID);

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
        $subscriptionCancelRequest = new SubscriptionCancel(self::SUBSCRIPTION_ID);

        $this->assertEquals(
            $subscriptionCancelRequest->getMethod(),
            self::METHOD
        );
    }

    /**
     * @test
     */
    public function mustPathBeCorrect()
    {
        $subscriptionCancelRequest = new SubscriptionCancel(self::SUBSCRIPTION_ID);

        $this->assertEquals(
            $subscriptionCancelRequest->getPath(),
            self::PATH
        );
    }
}
