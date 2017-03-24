<?php

namespace PagarMe\SdkTest\BankAccount\Request;

use PagarMe\Sdk\BulkAnticipation\BulkAnticipationHandler;
use PagarMe\Sdk\RequestInterface;

class BulkAnticipationHandlerTest extends \PHPUnit_Framework_TestCase
{
    const RECIPIENT_ID = 're_123456';

    /**
     * @test
     */
    public function mustHandlerParseBulkAnticipationCorrectly() {
        $recipientMock = $this->getMockBuilder('PagarMe\Sdk\Recipient\Recipient')
            ->disableOriginalConstructor()
            ->getMock();
        $recipientMock->method('getId')->willReturn(self::RECIPIENT_ID);

        $clientMock = $this->getMockBuilder('PagarMe\Sdk\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $expectedDateCreated = '2017-03-24T13:32:03.519Z';
        $expectedDateUpdated = '2017-03-24T13:32:03.519Z';
        $expectedPaymentDate = '2017-05-01T03:00:00.000Z';

        $clientMock->method('send')->willReturn(
            json_decode('{
                "object": "bulk_anticipation",
                "id": "ba_testtesttesttest",
                "status": "building",
                "amount": 1000,
                "fee": 50,
                "anticipation_fee": 34,
                "type": "spot",
                "timeframe": "start",
                "payment_date": "' . $expectedPaymentDate . '",
                "date_created": "' . $expectedDateCreated . '",
                "date_updated": "' . $expectedDateUpdated . '"
            }')
        );

        $bulkAnticipationHandler = new BulkAnticipationHandler($clientMock);

        $bulkAnticipation = $bulkAnticipationHandler->create(
            $recipientMock,
            new \Datetime(),
            'start',
            '1000',
            true
        );

        $this->assertEquals(new \DateTime($expectedDateCreated), $bulkAnticipation->getDateCreated());
        $this->assertEquals(new \DateTime($expectedDateUpdated), $bulkAnticipation->getDateUpdated());
        $this->assertEquals(new \DateTime($expectedPaymentDate), $bulkAnticipation->getPaymentDate());
    }
}
