<?php

namespace PagarMe\Test\Endpoints;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use PagarMe\Client;

abstract class PagarMeTestCase extends TestCase
{
    /**
     * @var array $container
     */
    public $container;

    /**
     * @param string $mockName
     *
     * @return string
     */
    protected static function jsonMock($mockName)
    {
        return file_get_contents(__DIR__."/../Mocks/$mockName.json");
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
     * @param array $container
     * @param GuzzleHttp\Handler\MockHandler $mock
     *
     * @return PagarMe\Client
     */
    protected static function buildClient(&$container, $mock)
    {
        $history = Middleware::history($container);

        $handler = HandlerStack::create($mock);
        $handler->push($history);

        return new Client('apiKey', ['handler' => $handler]);
    }
}
