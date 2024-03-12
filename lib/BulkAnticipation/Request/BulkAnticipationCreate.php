<?php

namespace PagarMe\Sdk\BulkAnticipation\Request;

use PagarMe\Sdk\RequestInterface;
use PagarMe\Sdk\Recipient\Recipient;

class BulkAnticipationCreate implements RequestInterface
{
    use \PagarMe\Sdk\MicrosecondsFormatter;

    /**
     * @var  Recipient
     */
    private $recipient;

    /**
     * @var  DateTime
     */
    private $paymentDate;

    /**
     * @var  string
     */
    private $timeframe;

    /**
     * @var  int
     */
    private $requestedAmount;

    /**
     * @param  Recipient $recipient
     * @param  \DateTime $paymentDate
     * @param  string $timeframe
     * @param  int $requestedAmount
     */
    public function __construct(
        Recipient $recipient,
        \DateTime $paymentDate,
        $timeframe,
        $requestedAmount
    ) {
        $this->recipient       = $recipient;
        $this->paymentDate     = $paymentDate;
        $this->timeframe       = $timeframe;
        $this->requestedAmount = $requestedAmount;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [
            'payment_date'     => $this->getDateInMicroseconds(
                $this->paymentDate
            ),
            'timeframe'        => $this->timeframe,
            'requested_amount' => $this->requestedAmount
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return sprintf(
            'recipients/%s/bulk_anticipations',
            $this->recipient->getId()
        );
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_POST;
    }
}
