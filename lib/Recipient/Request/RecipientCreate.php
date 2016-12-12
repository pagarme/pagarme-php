<?php

namespace PagarMe\Sdk\Recipient\Request;

use PagarMe\Sdk\Request;
use PagarMe\Sdk\BankAccount\BankAccount;

class RecipientCreate implements Request
{

    private $bankAccount;
    private $transferInterval;
    private $transferDay;
    private $transferEnabled;
    private $automaticAnticipationEnabled;
    private $anticipatableVolumePercentage;

    public function __construct(
        BankAccount $bankAccount,
        $transferInterval,
        $transferDay,
        $transferEnabled,
        $automaticAnticipationEnabled,
        $anticipatableVolumePercentage
    ) {
        $this->bankAccount                   = $bankAccount;
        $this->transferInterval              = $transferInterval;
        $this->transferDay                   = $transferDay;
        $this->transferEnabled               = $transferEnabled;
        $this->automaticAnticipationEnabled  = $automaticAnticipationEnabled;
        $this->anticipatableVolumePercentage = $anticipatableVolumePercentage;
    }

    public function getPayload()
    {
        $payload = [
            'transfer_interval'               => $this->transferInterval,
            'transfer_day'                    => $this->transferDay,
            'transfer_enabled'                => $this->transferEnabled,
            'automatic_anticipation_enabled'  => $this->automaticAnticipationEnabled,
            'anticipatable_volume_percentage' => $this->anticipatableVolumePercentage,
        ];

        return array_merge($payload, $this->getBankAccountData());
    }

    public function getPath()
    {
        return 'recipients';
    }

    public function getMethod()
    {
        return 'POST';
    }

    protected function getBankAccountData()
    {
        $bankAccount = $this->bankAccount;

        if (!is_null($bankAccount->getId())) {
            return ['bank_account_id' => $bankAccount->getId()];
        }

        return [
            'bank_account' =>[
                'bank_code'       => $bankAccount->getBankCode(),
                'agencia'         => $bankAccount->getAgencia(),
                'conta'           => $bankAccount->getConta(),
                'conta_dv'        => $bankAccount->getContaDv(),
                'document_number' => $bankAccount->getDocumentNumber(),
                'legal_name'      => $bankAccount->getLegalName()
            ]
        ];
    }
}
