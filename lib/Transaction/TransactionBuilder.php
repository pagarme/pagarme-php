<?php

namespace PagarMe\Sdk\Transaction;

trait TransactionBuilder
{
    use \PagarMe\Sdk\SplitRule\SplitRuleBuilder;
    use \PagarMe\Sdk\Customer\CustomerBuilder;
    use \PagarMe\Sdk\Card\CardBuilder;

    /**
     * @param array transactionData
     * @return Transaction
     */
    private function buildTransaction($transactionData)
    {
        if (isset($transactionData->split_rules)) {
            $transactionData->split_rules = $this->buildSplitRules(
                $transactionData->split_rules
            );
        }

        $transactionData->metadata = $this->parseMetadata($transactionData);

        $transactionData->date_created = new \DateTime(
            $transactionData->date_created
        );

        $transactionData->date_updated = new \DateTime(
            $transactionData->date_updated
        );

        if (isset($transactionData->customer)) {
            $transactionData->customer = $this->buildCustomerFromResponse(
                (object) $transactionData->customer,
                (object) $transactionData->address,
                (object) $transactionData->phone
            );
        }

        if (isset($transactionData->card)) {
            $transactionData->card = $this->buildCard((object) $transactionData->card);
        }

        if ($transactionData->payment_method == BoletoTransaction::PAYMENT_METHOD) {
            $transactionData->boleto_expiration_date = new \DateTime(
                $transactionData->boleto_expiration_date
            );

            return new BoletoTransaction(get_object_vars($transactionData));
        }

        if ($transactionData->payment_method == CreditCardTransaction::PAYMENT_METHOD) {
            return new CreditCardTransaction(get_object_vars($transactionData));
        }

        if ($transactionData->payment_method == PixTransaction::PAYMENT_METHOD) {
            return new PixTransaction(get_object_vars($transactionData));
        }

        throw new UnsupportedTransaction(
            sprintf(
                'Transaction type: %s, is not supported',
                $transactionData->payment_method
            ),
            1
        );
    }

    /**
     * @param array $transactionData
     * @return array
     */
    private function parseMetadata($transactionData)
    {
        if (!isset($transactionData->metadata)) {
            return [];
        }

        if (is_null($transactionData->metadata)) {
            return [];
        }

        if (is_array($transactionData->metadata)) {
            return $transactionData->metadata;
        }

        return get_object_vars($transactionData->metadata);
    }
}
