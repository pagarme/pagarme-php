<?php

namespace PagarMe\Sdk\Customer;

trait PhoneBuilder
{
    /**
     * @param array $phoneData
     * @return Phone
     */
    private function buildPhone($phoneData)
    {
        $phone = new Phone(
            $phoneData->ddd,
            $phoneData->number,
            $phoneData->ddi
        );

        return $phone;
    }
}
