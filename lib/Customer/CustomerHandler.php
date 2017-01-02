<?php

namespace PagarMe\Sdk\Customer;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Client;
use PagarMe\Sdk\Customer\Request\CustomerCreate;
use PagarMe\Sdk\Customer\Request\CustomerGet;
use PagarMe\Sdk\Customer\Request\CustomerList;

class CustomerHandler extends AbstractHandler
{
    use AddressBuilder;
    use PhoneBuilder;

    /**
     * @param string $name
     * @param string $email
     * @param int $documentNumber
     * @param Address $address
     * @param Phone $phone
     * @param string $bornAt
     * @param string $gender
     */
    public function create(
        $name,
        $email,
        $documentNumber,
        Address $address,
        Phone $phone,
        $bornAt = null,
        $gender = null
    ) {
        $request = new CustomerCreate(
            $name,
            $email,
            $documentNumber,
            $address,
            $phone,
            $bornAt,
            $gender
        );

        $response = $this->client->send($request);

        return $this->buildCustomer($response);
    }

    /**
     * @param int $customerId
     */
    public function get($customerId)
    {
        $request = new CustomerGet($customerId);
        $response = $this->client->send($request);

        return $this->buildCustomer($response);
    }

    /**
     * @param int $page
     * @param int $count
     */
    public function getList($page = 1, $count = 10)
    {
        $request = new CustomerList($page, $count);
        $response = $this->client->send($request);

        $customers = [];
        foreach ($response as $customerResponse) {
            $customers[] = $this->buildCustomer($customerResponse);
        }

        return $customers;
    }

    /**
     * @param array $customerData
     * @return Customer
     */
    private function buildCustomer($customerData)
    {
        $customerData->address = $this->buildAddress(
            $customerData->addresses[0]
        );

        $customerData->phone = $this->buildPhone(
            $customerData->phones[0]
        );

        $customerData->date_created = new \DateTime(
            $customerData->date_created
        );

        return new Customer(get_object_vars($customerData));
    }
}
