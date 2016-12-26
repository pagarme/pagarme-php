<?php

namespace PagarMe\Sdk\Balance;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\Balance\Request\BalanceOperationsList;
use PagarMe\Sdk\Balance\Operation;
use PagarMe\Sdk\Balance\Movement;

class BalanceOperationsHandler extends AbstractHandler
{
    /**
     * @param int $page
     * @param int $count
     * @return array
     */
    public function operations($page = null, $count = null)
    {
        $request = new BalanceOperationsList($page, $count);

        $result = $this->client->send($request);
        $operations = [];

        foreach ($result as $operation) {
            $operation->movement = new Movement($operation->movement_object);
            $operations[]= new Operation(get_object_vars($operation));
        }

        return $operations;
    }
}
