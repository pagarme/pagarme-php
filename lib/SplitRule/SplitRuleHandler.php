<?php

namespace PagarMe\Sdk\SplitRule;

use PagarMe\Sdk\Recipient\Recipient;

class SplitRuleHandler
{
    /**
     * @param int $value
     * @param Recipient $recipient
     * @param bool $liable
     * @param bool $chargeProcessingFee
     * @param bool $chargeRemainder
     * @return SplitRule
     */
    public function monetaryRule(
        $value,
        Recipient $recipient,
        $liable = null,
        $chargeProcessingFee = null,
        $chargeRemainder = null
    ) {
        return new SplitRule(
            [
                'amount'              => $value,
                'recipient'           => $recipient,
                'liable'              => $liable,
                'chargeProcessingFee' => $chargeProcessingFee,
                'chargeRemainder'     => $chargeRemainder,
            ]
        );
    }

    /**
     * @param int $value
     * @param Recipient $recipient
     * @param bool $liable
     * @param bool $chargeProcessingFee
     * @param bool $chargeRemainder
     * @return SplitRule
     */
    public function percentageRule(
        $value,
        Recipient $recipient,
        $liable = null,
        $chargeProcessingFee = null,
        $chargeRemainder = null
    ) {
        return new SplitRule(
            [
                'percentage'          => $value,
                'recipient'           => $recipient,
                'liable'              => $liable,
                'chargeProcessingFee' => $chargeProcessingFee,
                'chargeRemainder'     => $chargeRemainder,
            ]
        );
    }
}
