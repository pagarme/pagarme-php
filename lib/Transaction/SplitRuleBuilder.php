<?php

namespace PagarMe\Sdk\Transaction;

use PagarMe\Sdk\SplitRule\SplitRuleCollection;
use PagarMe\Sdk\SplitRule\SplitRule;

trait SplitRuleBuilder
{
    private function buildSplitRules($splitRuleData)
    {
        $rules = new SplitRuleCollection();

        foreach ($splitRuleData as $rule) {
            $rule->recipient = new Recipient(['id' =>$rule->recipient_id]);
            $rules[] = new SplitRule(get_object_vars($rule));
        }

        return $rules;
    }
}
