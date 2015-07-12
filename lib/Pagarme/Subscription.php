<?php

namespace Pagarme;

class Subscription extends TransactionCommon
{
    public function create()
    {
        $this->checkPlan();
        parent::create();
    }

    public function save()
    {
        $this->checkPlan();
        parent::save();
    }

    public function getTransactions()
    {
        $request = new Request();
        $response = $request->send(self::getUrl() . '/' . $this->id . '/transactions', 'GET');
        $this->transactions = Util::convertToPagarMeObject($response);
        return $this->transactions;
    }

    public function cancel()
    {
        $request = new Request();
        $response = $request->send(self::getUrl() . '/' . $this->id . '/cancel', 'POST');
        $this->refresh($response);
    }

    public function charge($amount, $installments = 1)
    {
        $this->amount = $amount;
        $this->installments = $installments;
        $request = new Request();
        $request->setParameters($this->unsavedarray());
        $response = $request->send(self::getUrl() . '/' . $this->id . '/transactions', 'POST');

        $request = new Request();
        $response = $request->send(self::getUrl() . '/' . $this->id, 'GET');
        $this->refresh($response);
    }

    private function checkPlan()
    {
        if ($this->plan) {
            $this->plan_id = $this->plan->id;
            unset($this->plan);
        }
    }
}