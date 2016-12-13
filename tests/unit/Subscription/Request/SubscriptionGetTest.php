<?php

namespace PagarMe\SdkTest\Subscription\Request;

use PagarMe\Sdk\Subscription\Request\SubscriptionGet;

class SubscriptionGetTest extends \PHPUnit_Framework_TestCase
{
    const METHOD          = 'GET';
    const PATH            = 'subscriptions/123';
    const SUBSCRIPTION_ID = 123;

    /**
     * @test
    **/
    public function mustPayloadBeCorrect()
    {
        $subscriptionGetRequest = new SubscriptionGet(self::SUBSCRIPTION_ID);

        $this->assertEquals(
            $subscriptionGetRequest->getPayload(),
            []
        );
    }

    /**
     * @test
    **/
    public function mustMethodBeCorrect()
    {
        $subscriptionGetRequest = new SubscriptionGet(self::SUBSCRIPTION_ID);

        $this->assertEquals(
            $subscriptionGetRequest->getMethod(),
            self::METHOD
        );
    }

    /**
     * @test
    **/
    public function mustPathBeCorrect()
    {
        $subscriptionGetRequest = new SubscriptionGet(self::SUBSCRIPTION_ID);

        $this->assertEquals(
            $subscriptionGetRequest->getPath(),
            self::PATH
        );
    }
}
