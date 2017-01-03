<?php

namespace PagarMe\SdkTest\Customer\Request;

use PagarMe\Sdk\Customer\Request\CustomerCreate;
use PagarMe\Sdk\Customer\Customer;

class CustomerCreateTest extends \PHPUnit_Framework_TestCase
{
    const PATH            = 'customers';
    const METHOD          = 'POST';

    const NAME            = 'Eduardo Nascimento';
    const EMAIL           = 'eduardo@eduardo.com';
    const DOCUMENT_NUMBER = '10586649727';
    const BORN_AT         = '15071991';
    const GENDER          = 'M';

    const STREET          = 'rua teste';
    const STREET_NUMBER   = 42;
    const NEIGHBORHOOD    = 'centro';
    const ZIPCODE         = '01227200';

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $address = new \PagarMe\Sdk\Customer\Address(
            self::STREET,
            self::STREET_NUMBER,
            self::NEIGHBORHOOD,
            self::ZIPCODE
        );
        $address->setComplementary('Apto 42');
        $address->setCity('São Paulo');
        $address->setState('SP');
        $address->setCountry('Brasil');

        $customerCreate = new CustomerCreate(
            self::NAME,
            self::EMAIL,
            self::DOCUMENT_NUMBER,
            $address,
            new \PagarMe\Sdk\Customer\Phone(15, 987523421),
            self::BORN_AT,
            self::GENDER
        );

        $this->assertEquals(
            [
                'born_at'         => '15071991',
                'document_number' => '10586649727',
                'email'           => 'eduardo@eduardo.com',
                'gender'          => 'M',
                'name'            => 'Eduardo Nascimento',
                'address' => [
                    'street'        => 'rua teste',
                    'street_number' => 42,
                    'neighborhood'  => 'centro',
                    'zipcode'       => '01227200',
                    'complementary' => 'Apto 42',
                    'city'          => 'São Paulo',
                    'state'         => 'SP',
                    'country'       => 'Brasil'
                ],
                'phone' => [
                    'ddd'    => 15,
                    'number' => 987523421
                ]
            ],
            $customerCreate->getPayload()
        );
    }

    /**
     * @test
     */
    public function mustPathBeCorrect()
    {
        $customerCreate = new CustomerCreate(
            self::NAME,
            self::EMAIL,
            self::DOCUMENT_NUMBER,
            $this->getAddressMock(),
            $this->getPhoneMock(),
            null,
            null
        );

        $this->assertEquals(self::PATH, $customerCreate->getPath());
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $customerCreate = new CustomerCreate(
            self::NAME,
            self::EMAIL,
            self::DOCUMENT_NUMBER,
            $this->getAddressMock(),
            $this->getPhoneMock(),
            null,
            null
        );

        $this->assertEquals(self::METHOD, $customerCreate->getMethod());
    }

    private function getAddressMock()
    {
        return $this->getMockBuilder('PagarMe\Sdk\Customer\Address')
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getPhoneMock()
    {
        return $this->getMockBuilder('PagarMe\Sdk\Customer\Phone')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
