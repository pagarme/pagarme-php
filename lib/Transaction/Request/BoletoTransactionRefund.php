<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Transaction\BoletoTransaction;
use PagarMe\Sdk\Account\Account;

class BoletoTransactionRefund implements Request
{
    protected $transaction;
    protected $account;
    protected $amount;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        BoletoTransaction $transaction,
        Account $account,
        $amount
    ) {
        $this->transaction = $transaction;
        $this->account     = $account;
        $this->amount      = $amount;
    }

    public function getPayload()
    {
        return array_merge(
            ['amount' => $this->amount],
            $this->getAccountData()
        );
    }

    public function getPath()
    {
        return sprintf('transactions/%d/refund', $this->transaction->getId());
    }

    public function getMethod()
    {
        return 'POST';
    }

    private function getAccountData()
    {
        $account = $this->account;

        if (is_null($account->getBankAccountId())) {
            return [
                'bank_code'       => $account->getBankCode(),
                'agencia'         => $account->getAgencia(),
                'agencia_dv'      => $account->getAgenciaDv(),
                'conta'           => $account->getConta(),
                'conta_dv'        => $account->getContaDv(),
                'document_number' => $account->getDocumentNumber(),
                'legal_name'      => $account->getLegalName()
            ];
        }

        return ['bank_account_id' => $account->getBankAccountId()];
    }

    /**
     * @return string
     */
    public function getAuthenticationMethod()
    {
        return self::API_KEY;
    }
}
