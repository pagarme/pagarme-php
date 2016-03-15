<?php
namespace Pagarme\Transaction;

use Pagarme\Request as PagarmeRequest;

/**
 * Class Transaction
 * @package Pagarme\Transaction
 */
class Transaction extends Common
{

    /**
     * @return $this
     */
    public function charge()
    {
        $this->create();

        return $this;
    }

    /**
     * @param bool|false $data
     * @return $this
     * @throws \Pagarme\Exception
     */
    public function capture($data = false)
    {
        $request = new PagarmeRequest(self::getUrl() . '/' . $this->id . '/capture', 'POST');

        if (gettype($data) == 'array'):
            $request->setParameters($data);
        else:
            if ($data)
                $request->setParameters(array('amount' => $data));

        endif;

        $response = $request->run();
        $this->refresh($response);

        return $this;
    }

    /**
     * @param array $params
     * @return $this
     * @throws \Pagarme\Exception
     */
    public function refund($params = array())
    {
        $request = new PagarmeRequest(self::getUrl() . '/' . $this->id . '/refund', 'POST');
        $request->setParameters($params);
        $response = $request->run();
        $this->refresh($response);

        return $this;
    }
}
