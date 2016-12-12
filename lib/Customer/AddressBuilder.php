<?php

namespace PagarMe\Sdk\Customer;

trait AddressBuilder
{
    /**
     * @param array $addressData
     * @return Address
     */
    private function buildAddress($addressData)
    {
        $address = new Address(
            $addressData->street,
            $addressData->street_number,
            $addressData->neighborhood,
            $addressData->zipcode
        );

        $address->setComplementary($addressData->complementary);
        $address->setCity($addressData->city);
        $address->setState($addressData->state);
        $address->setCountry($addressData->country);

        return $address;
    }
}
