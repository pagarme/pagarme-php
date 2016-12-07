<?php

namespace PagarMe\Sdk\BankAccount;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\BankAccount\Request\BankAccountCreate;
use PagarMe\Sdk\BankAccount\Request\BankAccountList;
use PagarMe\Sdk\BankAccount\Request\BankAccountGet;

class BankAccountHandler extends AbstractHandler
{
    /**
     * @param $bankCode int
     * @param $agencia int
     * @param $conta int
     * @param $contaDv int
     * @param $documentNumber string
     * @param $legalName string
     * @param $agenciaDv int
     */
    public function create(
        $bankCode,
        $agencia,
        $conta,
        $contaDv,
        $documentNumber,
        $legalName,
        $agenciaDv = null
    ) {
        $request = new BankAccountCreate(
            $bankCode,
            $agencia,
            $conta,
            $contaDv,
            $documentNumber,
            $legalName,
            $agenciaDv
        );

        $result = $this->client->send($request);

        return new BankAccount(get_object_vars($result));
    }

    /**
     * @param $page int
     * @param $count int
     */
    public function getList($page = null, $count = null)
    {
        $request = new BankAccountList($page, $count);

        $result = $this->client->send($request);

        $bankAccounts = [];
        foreach ($result as $bankData) {
            $bankAccounts[] = new BankAccount(get_object_vars($bankData));
        }

        return $bankAccounts;
    }

    /**
     * @param $bankAccountId int
     */
    public function get($bankAccountId)
    {
        $request = new BankAccountGet($bankAccountId);

        $result = $this->client->send($request);

        return new BankAccount(get_object_vars($result));
    }
}
