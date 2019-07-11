<?php

namespace PagarMe\Test;

use PagarMe\Exceptions\PagarMeException;
use PHPUnit\Framework\TestCase;

final class PagarMeExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function buildExceptionMessage()
    {
        $exception = new PagarMeException(
            'InvalidType',
            'items',
            'value must be array'
        );
        $errorType = 'InvalidType';
        $parameter = 'items';
        $message = 'value must be array';

        $expectedMessage = sprintf(
            'ERROR TYPE: %s. PARAMETER: %s. MESSAGE: %s',
            $errorType,
            $parameter,
            $message
        );
        $this->assertEquals($expectedMessage, $exception->getMessage());
    }
}
