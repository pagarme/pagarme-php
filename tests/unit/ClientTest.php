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

        $this->requestMock = $this->getMockBuilder('PagarMe\Sdk\RequestInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestMock->method('getMethod')->willReturn(RequestInterface::HTTP_POST);
        $this->requestMock->method('getPath')->willReturn(self::REQUEST_PATH);
        $this->requestMock->method('getPayload')->willReturn(
            ['content' => self::CONTENT]
        );
    }

    /**
     * @test
     */
    public function mustSendRequest()
    {
        $this->guzzleClientMock->method('createRequest')
            ->willReturn($this->getMock('GuzzleHttp\Message\RequestInterface'));

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

        $this->guzzleClientMock->expects($this->once())->method('send')
            ->willReturn($responseMock);

        $client = new Client(
            $this->guzzleClientMock,
            self::API_KEY
        );

        $client->send($this->requestMock);
    }

    /**
     * @test
     */
    public function mustSendRequestWithProperContent()
    {
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

        $responseMock = $this->getMockBuilder('GuzzleHttp\Psr7\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $streamMock = $this->getMockBuilder('Psr\Http\Message\StreamInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $responseMock->method('getBody')
            ->willReturn($streamMock);

        $this->guzzleClientMock->expects($this->once())->method('send')
            ->willReturn($responseMock);

        $client = new Client(
            $this->guzzleClientMock,
            self::API_KEY
        );

        $client->send($this->requestMock);
    }

    /**
    * @expectedException PagarMe\Sdk\ClientException
    * @test
     */
    public function mustReturnClientExeptionWhenGetRequestException()
    {
        $guzzleRequestMock = $this->getMock(
            'Psr\Http\Message\RequestInterface'
        );

        $this->guzzleClientMock->method('createRequest')
            ->willReturn($guzzleRequestMock);

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
        $client->send($this->requestMock);
    }

    /**
     * @test
     */
    public function mustSetDefaultTimeout()
    {
        $timeout = 237;

        $this->guzzleClientMock->method('createRequest')
            ->willReturn($this->getMock('GuzzleHttp\Message\RequestInterface'));

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

        $this->guzzleClientMock->expects($this->once())
            ->method('send')
            ->with(
                $this->isInstanceOf('GuzzleHttp\Psr7\Request'),
                ['timeout' => $timeout]
            )->willReturn($responseMock);

        $client = new Client(
            $this->guzzleClientMock,
            self::API_KEY,
            $timeout
        );

        $client->send($this->requestMock);
    }
}
