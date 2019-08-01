<?php

namespace PagarMe\Test;

use PagarMe\ResponseHandler;
use PHPUnit\Framework\TestCase;

class ResponseHandlerTest extends TestCase
{
    public function testReturnTypeOnSuccess()
    {
        $handler = new ResponseHandler();

        $response = $handler->success('{"foo": "bar"}');

        $this->assertInstanceOf(\stdClass::class, $response);
    }

    public function testReturnUsage()
    {
        $response = ResponseHandler::success('{"foo": "bar"}');

        $this->assertObjectHasAttribute('foo', $response);
        $this->assertEquals('bar', $response->foo);
    }

    public function testReturnListOfObjects()
    {
        $response = ResponseHandler::success('[{"foo": "bar"},{"bar": "baz"}]');

        $this->assertInternalType('array', $response, 'The list must be an array');
        $this->assertObjectHasAttribute('foo', $response[0], 'The first index must be an object');
        $this->assertEquals('bar', $response[0]->foo);
        $this->assertObjectHasAttribute('bar', $response[1], 'The second index must be an object');
        $this->assertEquals('baz', $response[1]->bar);
    }

    /**
     * @expectedException \PagarMe\Exceptions\InvalidJsonException
     */
    public function testUnparseablePayload()
    {
        $response = ResponseHandler::success('{"foo": "bar"');
    }
}
