<?php

namespace PagarMe;

class Anonymous extends \stdClass
{
    public function __call($methodName, $params)
    {
        if (!isset($this->{$methodName})) {
            throw new \Exception('Call to undefined method ' . __CLASS__ . '::' . $methodName . '()');
        }

        return $this->{$methodName}->__invoke(... $params);
    }
}
