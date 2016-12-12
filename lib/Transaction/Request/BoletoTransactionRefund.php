<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\Transaction\BoletoTransaction;
use PagarMe\Sdk\BankAccount\BankAccount;

class BoletoTransactionRefund implements Request
{
    protected $transaction;
    protected $bankAccount;
    protected $amount;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        BoletoTransaction $transaction,
        BankAccount $bankAccount,
        $amount
    ) {
        $this->transaction = $transaction;
        $this->bankAccount = $bankAccount;
        $this->amount      = $amount;
    }

    public function getPayload()
    {
        return array_merge(
            ['amount' => $this->amount],
            $this->getBankAccountData()
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

    private function getBankAccountData()
    {
        $bankAccount = $this->bankAccount;

        if (is_null($bankAccount->getId())) {
            return [
                'bank_code'       => $bankAccount->getBankCode(),
                'agencia'         => $bankAccount->getAgencia(),
                'agencia_dv'      => $bankAccount->getAgenciaDv(),
                'conta'           => $bankAccount->getConta(),
                'conta_dv'        => $bankAccount->getContaDv(),
                'document_number' => $bankAccount->getDocumentNumber(),
                'legal_name'      => $bankAccount->getLegalName()
            ];
        }

        return ['bank_account_id' => $bankAccount->getId()];
    }
}
