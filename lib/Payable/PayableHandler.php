<?php

namespace PagarMe\Sdk\Payable;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Payable\Request\PayableGet;

class PayableHandler extends AbstractHandler
{
    /**
     * @param int $payableId
     */
    public function get($payableId)
    {
        $request = new PayableGet($payableId);

        $response = $this->client->send($request);

        return new Payable(get_object_vars($response));
    }
}
