<?php

namespace PagarMe\Sdk\Plan;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Plan\Request\PlanCreate;
use PagarMe\Sdk\Plan\Request\PlanList;

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

    public function getList($page = null, $count = null)
    {
        $request = new PlanList(
            $page,
            $count
        );

        $response = $this->client->send($request);
        $plans = [];
        foreach ($response as $planData) {
            $plans[] = new Plan(get_object_vars($planData));
        }

        return $plans;
    }
}
