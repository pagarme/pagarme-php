<?php

namespace PagarMe\Sdk;

trait MicrosecondsFormatter
{
    /**
     * @param \DateTime $date
     * @return string
     */
    public function getDateInMicroseconds($date)
    {
        return substr($date->format('Uu'), 0, 13);
    }
}
