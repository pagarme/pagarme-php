<?php

namespace PagarMe\SdkTest;

use PagarMe\Sdk\Client;
use PagarMe\Sdk\RequestInterface;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    const REQUEST_PATH   = 'test';
    const CONTENT        = 'sample content';
    const API_KEY        = 'myApiKey';

    /**
     * @test
     */
    public function mustSendRequest()
    {
        $guzzleClientMock = $this->getMockBuilder('GuzzleHttp\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $guzzleClientMock->expects($this->once())
            ->method('createRequest')
            ->willReturn($this->getMock('GuzzleHttp\Message\RequestInterface'));

        $responseMock = $this->getMockBuilder('GuzzleHttp\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $streamMock = $this->getMockBuilder('GuzzleHttp\Stream\Stream')
            ->disableOriginalConstructor()
            ->getMock();

        $responseMock->method('getBody')
            ->willReturn($streamMock);

        $guzzleClientMock->expects($this->once())->method('send')
            ->willReturn($responseMock);

        $request = $this->getMockBuilder('PagarMe\Sdk\RequestInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $request->method('getMethod')->willReturn(RequestInterface::HTTP_POST);
        $request->method('getPath')->willReturn(self::REQUEST_PATH);
        $request->method('getPayload')->willReturn(
            ['content' => self::CONTENT]
        );

        $client = new Client(
            $guzzleClientMock,
            self::API_KEY
        );

        $client->send($request);
    }

    /**
     * @test
     */
    public function mustSendRequestWithProperContent()
    {
        $guzzleClientMock = $this->getMockBuilder('GuzzleHttp\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $guzzleClientMock->expects($this->once())
            ->method('createRequest')
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

        $responseMock = $this->getMockBuilder('GuzzleHttp\Message\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $streamMock = $this->getMockBuilder('GuzzleHttp\Stream\Stream')
            ->disableOriginalConstructor()
            ->getMock();

        $responseMock->method('getBody')
            ->willReturn($streamMock);

        $guzzleClientMock->expects($this->once())->method('send')
            ->willReturn($responseMock);

        $request = $this->getMockBuilder('PagarMe\Sdk\RequestInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $request->method('getMethod')->willReturn(RequestInterface::HTTP_POST);
        $request->method('getPath')->willReturn(self::REQUEST_PATH);
        $request->method('getPayload')->willReturn(
            ['content' => self::CONTENT]
        );

        $client = new Client(
            $guzzleClientMock,
            self::API_KEY
        );

        $client->send($request);
    }

    /**
    * @expectedException PagarMe\Sdk\ClientException
    * @test
     */
    public function mustReturnClientExeptionWhenGetRequestException()
    {
        $guzzleClientMock = $this->getMockBuilder('GuzzleHttp\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $requestMock = $this->getMock('GuzzleHttp\Message\RequestInterface');

        $guzzleClientMock->expects($this->once())
            ->method('createRequest')
            ->willReturn($requestMock);

        $guzzleClientMock->method('send')
            ->will(
                $this->throwException(
                    new \GuzzleHttp\Exception\RequestException(
                        'Exception',
                        $requestMock
                    )
                )
            );

        $guzzleClientMock->expects($this->once())->method('send');

        $request = $this->getMockBuilder('PagarMe\Sdk\RequestInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $request->method('getMethod')->willReturn(RequestInterface::HTTP_POST);
        $request->method('getPath')->willReturn(self::REQUEST_PATH);
        $request->method('getPayload')->willReturn(
            ['content' => self::CONTENT]
        );

        $client = new Client(
            $guzzleClientMock,
            self::API_KEY
        );

        $client->send($request);
    }
}
