<?php

namespace PagarMe\SdkTest\Calculation\Request;

use PagarMe\Sdk\Calculation\Request\CalculateInstallmentsRequest;

class CalculateInstallmentsRequestTest extends \PHPUnit_Framework_TestCase
{
    const PATH   = 'transactions/calculate_installments_amount';
    const METHOD = 'GET';

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $calculateInstallmentsRequest = $this->getCalculateInstallmentsRequest();

        $this->assertEquals(
            [
                'amount'            => 1000,
                'interest_rate'     => 10,
                'free_installments' => 3,
                'max_installments'  => 7
            ],
            $calculateInstallmentsRequest->getPayload()
        );
    }

    /**
     * @test
     */
    public function mustPathBeCorrect()
    {
        $calculateInstallmentsRequest = $this->getCalculateInstallmentsRequest();

        $this->assertEquals(self::PATH, $calculateInstallmentsRequest->getPath());
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $calculateInstallmentsRequest = $this->getCalculateInstallmentsRequest();

        $this->assertEquals(self::METHOD, $calculateInstallmentsRequest->getMethod());
    }

    protected function getCalculateInstallmentsRequest()
    {
        return new CalculateInstallmentsRequest(
            1000,
            10,
            3,
            7
        );
    }
}
