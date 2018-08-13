<?php

namespace PagarMe;

class Anonymous extends \stdClass
{
    public function __call($key, $params)
    {
        if (!isset($this->{$key})) {
            throw new Exception("Call to undefined method " . __CLASS__ . "::" . $key . "()");
        }

        return $this->{$key}->__invoke(... $params);
    }
}
