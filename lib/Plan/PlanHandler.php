<?php

namespace PagarMe\Sdk\Plan;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Plan\Request\PlanCreate;

class PlanHandler extends AbstractHandler
{
    public function create(
        $amount,
        $days,
        $name,
        $trialDays = null,
        $paymentsMethods = [],
        $color = null,
        $charges = null,
        $installments = null
    ) {
        $request = new PlanCreate(
            $amount,
            $days,
            $name,
            $trialDays,
            $paymentsMethods,
            $color,
            $charges,
            $installments
        );

        $response = $this->client->send($request);

        return new Plan(get_object_vars($response));
    }
}
