<?php

namespace PagarMe\Test;

use PagarMe\ResponseHandler;
use PagarMe\PagarMeException;
use PHPUnit\Framework\TestCase;

class ResponseHandlerTest extends TestCase
{
    public function testReturnTypeOnSuccess()
    {
        $handler = new ResponseHandler();

        $response = $handler->success('{"foo": "bar"}');

        $this->assertInstanceOf(\ArrayObject::class, $response);
    }

    public function testReturnUsage()
    {
        $response = ResponseHandler::success('{"foo": "bar"}');
    
        $this->assertObjectHasAttribute('foo', $response);
        $this->assertEquals('bar', $response->foo);

        $this->assertArrayHasKey('foo', $response);
        $this->assertEquals('bar', $response['foo']);
    }

    /**
     * @expectedException \PagarMe\Exceptions\InvalidJsonException
     */
    public function testUnparseablePayload()
    {
        $response = ResponseHandler::success('{"foo": "bar"');
    }
}
