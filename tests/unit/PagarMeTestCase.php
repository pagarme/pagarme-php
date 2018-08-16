<?php

namespace PagarMe\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

abstract class PagarMeTestCase extends TestCase
{
    public $container;
    /**
     * @param string $mockName
     *
     * @return string
     */
    protected static function jsonMock($mockName)
    {
        return file_get_contents("tests/unit/Mocks/$mockName.json");
    }

    /**
     * @param array $container
     *
     * @return string
     */
    protected static function getRequestMethod($container)
    {
        return $container[0]['request']->getMethod();
    }

    /**
     * @param array $container
     *
     * @return string
     */
    protected static function getRequestUri($container)
    {
        return $container[0]['request']->getUri()->getPath();
    }

    /**
     * @param array @container
     * @param GuzzleHttp\Handler\MockHandler $mock
     *
     * @return GuzzleHttp\HandlerStack
     */
    protected static function buildHandler(&$container, $mock)
    {
        $history = Middleware::history($container);

        $handler = HandlerStack::create($mock);
        $handler->push($history);

        return $handler;
    }
}
