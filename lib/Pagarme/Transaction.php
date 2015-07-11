<?php

namespace Pagarme;

class Transaction extends TransactionCommon
{
    public function charge() 
    {
        $this->create();
    }

    public function capture($amount = false)
    {
        $request = new Request();

        if ($amount) { 
            $request->setParameters(array('amount' => $amount));
        }
        
        $response = $request->send(self::getUrl() . '/' . $this->id . '/capture', 'POST');
        $this->refresh($response);
    }

    public function refund($params = array()) 
    {
        $request = new Request();
        $request->setParameters($params);
        $response = $request->send(self::getUrl() . '/' . $this->id . '/refund', 'POST');
        $this->refresh($response);
    }
}