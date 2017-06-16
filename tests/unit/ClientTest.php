<?php

namespace PagarMe\SdkTest;

use GuzzleHttp\Client as GuzzleClient;
use PagarMe\Sdk\Client;
use PagarMe\Sdk\RequestInterface;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    const REQUEST_PATH   = 'test';
    const CONTENT        = 'sample content';
    const API_KEY        = 'myApiKey';

    private $guzzleClientMock;
    private $requestMock;

    public function setup()
    {
        $this->guzzleClientMock = $this->getMockBuilder('GuzzleHttp\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $this->pagarMeRequestMock = $this->getMockBuilder('PagarMe\Sdk\RequestInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->pagarMeRequestMock->method('getMethod')->willReturn(RequestInterface::HTTP_POST);
        $this->pagarMeRequestMock->method('getPath')->willReturn(self::REQUEST_PATH);
        $this->pagarMeRequestMock->method('getPayload')->willReturn(
            ['content' => self::CONTENT]
        );
    }

    /**
     * @test
     */
    public function mustSendRequest()
    {
        if ($this->isUsingLegacyGuzzle()) {
            $this->guzzleClientMock->method('createRequest')
                ->willReturn($this->getMock('GuzzleHttp\Message\RequestInterface'));
        }

        $responseMock = $this->getResponseMock();

        $this->guzzleClientMock->expects($this->once())->method('send')
            ->willReturn($responseMock);

        $client = new Client(
            $this->guzzleClientMock,
            self::API_KEY
        );

        $client->send($this->pagarMeRequestMock);
    }

    /**
     * @test
     */
    public function mustSendRequestWithProperContent()
    {
        if ($this->isUsingLegacyGuzzle()) {
            $this->guzzleClientMock->method('createRequest')
                ->with(
                    RequestInterface::HTTP_POST,
                    self::REQUEST_PATH,
                    [
                        'json' => [
                            'content'        => self::CONTENT,
                            'api_key'        => self::API_KEY
                        ]
                    ]
                )
                ->willReturn($this->getMock('GuzzleHttp\Message\RequestInterface'));
        }

        $responseMock = $this->getResponseMock();

        $this->guzzleClientMock->expects($this->once())->method('send')
            ->willReturn($responseMock);

        $client = new Client(
            $this->guzzleClientMock,
            self::API_KEY
        );

        $client->send($this->pagarMeRequestMock);
    }

    /**
    * @expectedException PagarMe\Sdk\ClientException
    * @test
     */
    public function mustReturnClientExeptionWhenGetRequestException()
    {
        $guzzleRequestMock = $this->getMock(
            $this->getGuzzleRequestInterfaceName()
        );

        if ($this->isUsingLegacyGuzzle()) {
            $this->guzzleClientMock->method('createRequest')
                ->willReturn($guzzleRequestMock);
        }

        $this->guzzleClientMock->method('send')
            ->will(
                $this->throwException(
                    new \GuzzleHttp\Exception\RequestException(
                        'Exception',
                        $guzzleRequestMock
                    )
                )
            );
        $this->guzzleClientMock->expects($this->once())->method('send');

        $client = new Client(
            $this->guzzleClientMock,
            self::API_KEY
        );
        $client->send($this->pagarMeRequestMock);
    }

    /**
     * @test
     */
    public function mustSetDefaultTimeout()
    {
        $timeout = 237;

        $guzzleRequestMock = $this->getMockBuilder(
            $this->getGuzzleRequestClassName()
            )->disableOriginalConstructor()
            ->getMock();

        if ($this->isUsingLegacyGuzzle()) {
            $this->guzzleClientMock->method('createRequest')
                ->willReturn($guzzleRequestMock);
        }

        $responseMock = $this->getResponseMock();

        $this->guzzleClientMock->expects($this->once())
            ->method('send')
            ->with(
                $this->isInstanceOf($this->getGuzzleRequestClassName()),
                ['timeout' => $timeout]
            )->willReturn($responseMock);

        $client = new Client(
            $this->guzzleClientMock,
            self::API_KEY,
            $timeout
        );

        $client->send($this->pagarMeRequestMock);
    }

    private function isUsingLegacyGuzzle()
    {
        return class_exists('\\GuzzleHttp\\Message\\Request');
    }

    private function getGuzzleRequestInterfaceName()
    {
        if ($this->isUsingLegacyGuzzle()) {
            return 'GuzzleHttp\Message\RequestInterface';
        }

        return 'Psr\Http\Message\RequestInterface';
    }

    private function getGuzzleRequestClassName()
    {
        if ($this->isUsingLegacyGuzzle()) {
            return 'GuzzleHttp\Message\Request';
        }

        return 'GuzzleHttp\Psr7\Request';
    }

    private function getResponseMock()
    {
        if ($this->isUsingLegacyGuzzle()) {
            $streamMock = $this->getMockBuilder(
            'GuzzleHttp\Stream\Stream'
            )->disableOriginalConstructor()
            ->getMock();

            $responseMock = $this->getMockBuilder(
                'GuzzleHttp\Message\Response'
                )->disableOriginalConstructor()
                ->getMock();

            $responseMock->method('getBody')
                ->willReturn($streamMock);

            return $responseMock;
        }

        $streamMock = $this->getMockBuilder(
            'Psr\Http\Message\StreamInterface'
            )->disableOriginalConstructor()
            ->getMock();

        $responseMock = $this->getMockBuilder(
            'GuzzleHttp\Psr7\Response'
            )->disableOriginalConstructor()
            ->getMock();

        $responseMock->method('getBody')
            ->willReturn($streamMock);

        return $responseMock;
    }
}
