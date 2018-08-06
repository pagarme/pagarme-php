<?php

namespace PagarMe\Test;

use PagarMe\RequestHandler;
use PHPUnit\Framework\TestCase;

class RequestHandlerTest extends TestCase
{
    public function testBindApiKey()
    {
        $this->assertEquals(
            'foo?api_key=katiau',
            RequestHandler::bindApiKey('foo', 'katiau')
        );
    }
}
