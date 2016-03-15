<?php
namespace Pagarme;

use Pagarme\Transaction\Common as TransactionCommon,
    Pagarme\Request as PagarmeRequest,
    Pagarme\Util as PagarmeUtil;

/**
 * Class Subscription
 * @package Pagarme
 */
class Subscription extends TransactionCommon
{

    public function create()
    {
        if ($this->plan):
            $this->plan_id = $this->plan->id;
            unset($this->plan);
        endif;

        parent::create();
    }


    public function save()
    {
        if ($this->plan):
            $this->plan_id = $this->plan->id;
            unset($this->plan);
        endif;

        parent::save();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getTransactions()
    {
        $request            = new PagarmeRequest(self::getUrl() . '/' . $this->id . '/transactions', 'GET');
        $response           = $request->run();
        $this->transactions = PagarmeUtil::convertToPagarMeObject($response);

        return $this->transactions;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function cancel()
    {
        $request  = new PagarmeRequest(self::getUrl() . '/' . $this->id . '/cancel', 'POST');
        $response = $request->run();
        $this->refresh($response);

        return $this;
    }

    /**
     * @param $amount
     * @param int $installments
     * @return $this
     * @throws Exception
     */
    public function charge($amount, $installments = 1)
    {
        $this->amount       = $amount;
        $this->installments = $installments;
        $request            = new PagarmeRequest(self::getUrl() . '/' . $this->id . '/transactions', 'POST');
        $request->setParameters($this->unsavedArray());
        $response = $request->run();

        $request  = new PagarmeRequest(self::getUrl() . '/' . $this->id, 'GET');
        $response = $request->run();
        $this->refresh($response);

        return $this;
    }
}
