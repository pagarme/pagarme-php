<?php

namespace PagarMe\Sdk\Transaction;

use PagarMe\Sdk\SplitRule\SplitRuleCollection;
use PagarMe\Sdk\SplitRule\SplitRule;
use PagarMe\Sdk\Recipient\Recipient;

trait SplitRuleBuilder
{
    private function buildSplitRules($splitRuleData)
    {
        $rules = new SplitRuleCollection();

        if (is_array($splitRuleData)) {
            foreach ($splitRuleData as $rule) {
                $rule->recipient = new Recipient(['id' =>$rule->recipient_id]);
                $rules[] = new SplitRule(get_object_vars($rule));
            }
        }

        return $rules;
    }
}
