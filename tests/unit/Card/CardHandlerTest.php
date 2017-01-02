<?php

namespace PagarMe\SdkTest\Card;

use PagarMe\Sdk\Card\CardHandler;

class CardHandlerTest extends \PHPUnit_Framework_TestCase
{
    const CARD_RETURN = '{"object":"card","id":"card_ci6y37h16wrxsmzyi","date_created":"2015-03-06T21:21:25.000Z","date_updated":"2015-03-06T21:21:26.000Z","brand":"visa","holder_name":"API CUSTOMER","first_digits":"401872","last_digits":"8048","fingerprint":"Jl9oOIiDjAjR","customer":null,"valid":true}';

    /**
     * @test
     */
    public function mustReturnCreatedCard()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->method('send')->willReturn(json_decode(self::CARD_RETURN));

        $handler =  new CardHandler($clientMock);
        $this->assertInstanceOf(
            'PagarMe\Sdk\Card\Card',
            $handler->create(
                4018720572598048,
                'API CUSTOMER',
                '0419'
            )
        );
    }

    /**
     * @test
     */
    public function mustReturnSpecificCard()
    {
        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $clientMock->method('send')->willReturn(json_decode(self::CARD_RETURN));

        $handler =  new CardHandler($clientMock);

        $cardId = 'card_ci6y37h16wrxsmzyi';

        $card = $handler->get($cardId);

        $this->assertInstanceOf(
            'PagarMe\Sdk\Card\Card',
            $card
        );

        $this->assertEquals($cardId, $card->getId());
    }
}
