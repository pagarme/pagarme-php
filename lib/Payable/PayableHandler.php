<?php

namespace PagarMe\Sdk\Payable;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Payable\Request\PayableGet;
use PagarMe\Sdk\Payable\Request\PayableList;
use PagarMe\Sdk\Payable\Request\TransactionPayableList;

class PayableHandler extends AbstractHandler
{
    use PayableBuilder;

    /**
     * @param int $payableId
     * @return Payable
     */
    public function get($payableId)
    {
        $request = new PayableGet($payableId);

        $response = $this->client->send($request);

        return $this->buildPayable($response);
    }

    /**
     * @param int $page
     * @param int $count
     *
     * @return Payable[]
     */
    public function getList($page = null, $count = null)
    {
        $request = new PayableList($page, $count);

        $response = $this->client->send($request);

        return $this->buildPayables($response);
    }

    /**
     * @param int $transactionId
     *
     * @return Payable[]
     */
    public function getTransactionPayableList($transactionId)
    {
        $request = new TransactionPayableList($transactionId);

        $response = $this->client->send($request);
        print_r($response);

        return $this->buildPayables($response);
    }
}
