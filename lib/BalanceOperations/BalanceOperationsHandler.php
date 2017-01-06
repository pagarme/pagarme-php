<?php

namespace PagarMe\Sdk\BalanceOperations;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\BankAccount\BankAccount;
use PagarMe\Sdk\BalanceOperations\Request\BalanceOperationsList;
use PagarMe\Sdk\BalanceOperations\Request\BalanceOperationsGet;
use PagarMe\Sdk\BalanceOperations\Operation;
use PagarMe\Sdk\BalanceOperations\Movement;

class BalanceOperationsHandler extends AbstractHandler
{
    use \PagarMe\Sdk\BalanceOperations\OperationBuilder;

    /**
     * @param int $page
     * @param int $count
     * @param string $status
     * @return array
     */
    public function getList($page = null, $count = null, $status = null)
    {
        $request = new BalanceOperationsList($page, $count, $status);

        $response = $this->client->send($request);
        $operations = [];

        foreach ($response as $operationData) {
            $operations[] = $this->buildOperation($operationData);
        }

        return $operations;
    }

    /**
     * @param int $balanceOperationId
     * @return Operation
     */
    public function get($balanceOperationId)
    {
        $request = new BalanceOperationsGet($balanceOperationId);

        $response = $this->client->send($request);

        return $this->buildOperation($response);
    }
}
