<?php

namespace PagarMe\Sdk\BulkAnticipation\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Recipient\Recipient;

class BulkAnticipationLimits implements Request
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
     * @param  Recipient $recipient
     * @param  DateTime $paymentDate
     * @param  string $timeframe
     */
    public function __construct(
        Recipient $recipient,
        \DateTime $paymentDate,
        $timeframe
    ) {
        $this->recipient       = $recipient;
        $this->paymentDate     = $paymentDate;
        $this->timeframe       = $timeframe;
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
            'timeframe'        => $this->timeframe
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return sprintf(
            'recipients/%s/bulk_anticipations/limits',
            $this->recipient->getId()
        );
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_GET;
    }

    private function getFormatedPaymentDate()
    {
        return substr(
            $this->paymentDate->format('Uu'),
            0,
            13
        );
    }
}
