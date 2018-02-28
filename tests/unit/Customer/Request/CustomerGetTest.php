<?php

namespace PagarMe\SdkTest\Customer\Request;

use PagarMe\Sdk\Customer\Request\CustomerGet;
use PagarMe\Sdk\RequestInterface;
use PHPUnit\Framework\TestCase;

class CustomerGetTest extends TestCase
{
    const PATH        = 'customers/1337';
    const CUSTOMER_ID = '1337';

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $customerGet = new CustomerGet(self::CUSTOMER_ID);

        $this->assertEquals([], $customerGet->getPayload());
    }

    /**
     * @test
     */
    public function mustPathBeCorrect()
    {
        $customerGet = new CustomerGet(self::CUSTOMER_ID);
        $this->assertEquals(self::PATH, $customerGet->getPath());
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $customerGet = new CustomerGet(self::CUSTOMER_ID);
        $this->assertEquals(RequestInterface::HTTP_GET, $customerGet->getMethod());
    }
}
