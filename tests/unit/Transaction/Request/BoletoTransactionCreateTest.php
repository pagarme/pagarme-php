<?php

namespace PagarMe\SdkTest\Transaction\Request;

use PagarMe\Sdk\Transaction\Request\BoletoTransactionCreate;
use PagarMe\Sdk\Transaction\BoletoTransaction;
use PagarMe\Sdk\SplitRule\SplitRuleCollection;
use PagarMe\Sdk\SplitRule\SplitRule;
use PagarMe\Sdk\Recipient\Recipient;
use PagarMe\Sdk\RequestInterface;

class BoletoTransactionCreateTest extends \PHPUnit_Framework_TestCase
{
    use FakeReferenceKey;

    const PATH   = 'transactions';

    const CARD_ID = 1;

    public function boletoOptions()
    {
        $customer = $this->getCustomerMock();

        return [
            [null, null],
            [date('Y-m-d', strtotime("tomorrow")), $this->getFakeReferenceKey()],
            [date('Y-m-d', strtotime("+15 days")), null]
        ];
    }

    /**
     * @dataProvider boletoOptions
     * @test
     */
    public function mustPayloadBeCorrect($expirationDate)
    {
        $transaction =  $this->createTransaction($expirationDate);
        $transactionCreate = new BoletoTransactionCreate($transaction);

        $this->assertEquals(
            [
                'amount'                 => 1337,
                'payment_method'         => 'boleto',
                'postback_url'           => 'example.com/postback',
                'boleto_expiration_date' => $expirationDate,
                'customer' => [
                    'name'            => 'Eduardo Nascimento',
                    'born_at'         => '15071991',
                    'document_number' => '10586649727',
                    'email'           => 'eduardo@eduardo.com',
                    'sex'             => 'M',
                    'address' => [
                        'street'        => 'rua teste',
                        'street_number' => 42,
                        'neighborhood'  => 'centro',
                        'zipcode'       => '01227200',
                        'complementary' => null
                    ],
                    'phone' => [
                        'ddi'    => 55,
                        'ddd'    => 15,
                        'number' => 987523421
                    ]
                ],
                'metadata' => null,
                'async' => null,
                'boleto_instructions' => null,
                'soft_descriptor' => null,
                'reference_key' => null
            ],
            $transactionCreate->getPayload()
        );
    }

    /**
     * @test
     * @dataProvider boletoOptions
     */
    public function mustContainsTheRightReferenceKey(
        $expirationDate,
        $referenceKey
    )
    {
        $transaction =  $this->createTransaction($expirationDate);
        $transactionCreate = new BoletoTransactionCreate($transaction);

        $this->assertEquals(
            [
                'amount'                 => 1337,
                'payment_method'         => 'boleto',
                'postback_url'           => 'example.com/postback',
                'boleto_expiration_date' => $expirationDate,
                'customer' => [
                    'name'            => 'Eduardo Nascimento',
                    'born_at'         => '15071991',
                    'document_number' => '10586649727',
                    'email'           => 'eduardo@eduardo.com',
                    'sex'             => 'M',
                    'address' => [
                        'street'        => 'rua teste',
                        'street_number' => 42,
                        'neighborhood'  => 'centro',
                        'zipcode'       => '01227200',
                        'complementary' => null
                    ],
                    'phone' => [
                        'ddi'    => 55,
                        'ddd'    => 15,
                        'number' => 987523421
                    ]
                ],
                'metadata' => null,
                'async' => null,
                'boleto_instructions' => null,
                'soft_descriptor' => null,
                'reference_key' => null
            ],
            $transactionCreate->getPayload()
        );
    }

    /**
     * @test
     */
    public function mustPayloadContainSplitRule()
    {
        $customerMock = $this->getCustomerMock();

        $rules = new SplitRuleCollection();
        $rules[]= new SplitRule([
            'amount'                => 100,
            'recipient'             => new Recipient(['id' => 1]),
            'liable'                => true,
            'charge_processing_fee' => true
        ]);
        $rules[]= new SplitRule([
            'percentage'            => 10,
            'recipient'             => new Recipient(['id' => 3]),
            'liable'                => false,
            'charge_processing_fee' => false
        ]);

        $expirationDate = strtotime("tomorrow");

        $transaction =  new BoletoTransaction(
            [
                'amount'                 => 1337,
                'postback_url'           => 'example.com/postback',
                'customer'               => $customerMock,
                'boleto_expiration_date' => $expirationDate,
                'split_rules'            => $rules,
                'reference_key'           => null
            ]
        );

        $transactionCreate = new BoletoTransactionCreate(
            $transaction,
            null,
            null,
            ['splitRules' => $rules]
        );

        $this->assertEquals(
            [
                'amount'                 => 1337,
                'payment_method'         => 'boleto',
                'postback_url'           => 'example.com/postback',
                'boleto_expiration_date' => $expirationDate,
                'customer' => [
                    'name'            => 'Eduardo Nascimento',
                    'born_at'         => '15071991',
                    'document_number' => '10586649727',
                    'email'           => 'eduardo@eduardo.com',
                    'sex'             => 'M',
                    'address' => [
                        'street'        => 'rua teste',
                        'street_number' => 42,
                        'neighborhood'  => 'centro',
                        'zipcode'       => '01227200',
                        'complementary' => null
                    ],
                    'phone' => [
                        'ddi'    => 55,
                        'ddd'    => 15,
                        'number' => 987523421
                    ]
                ],
                'split_rules' => [
                    0 => [
                        'amount'                => 100,
                        'recipient_id'          => 1,
                        'liable'                => true,
                        'charge_processing_fee' => true
                    ],
                    1 => [
                        'percentage'            => 10,
                        'recipient_id'          => 3,
                        'liable'                => false,
                        'charge_processing_fee' => false
                    ]
                ],
                'metadata' => null,
                'async' => null,
                'boleto_instructions' => null,
                'soft_descriptor' => null,
                'reference_key' => null
            ],
            $transactionCreate->getPayload()
        );
    }

    /**
     * @test
     */
    public function mustPathBeCorrect()
    {
        $transaction =  $this->getMockBuilder('PagarMe\Sdk\Transaction\BoletoTransaction')
            ->disableOriginalConstructor()
            ->getMock();

        $transactionCreate = new BoletoTransactionCreate($transaction);

        $this->assertEquals(self::PATH, $transactionCreate->getPath());
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $transaction =  $this->getMockBuilder('PagarMe\Sdk\Transaction\BoletoTransaction')
            ->disableOriginalConstructor()
            ->getMock();

        $transactionCreate = new BoletoTransactionCreate($transaction);

        $this->assertEquals(RequestInterface::HTTP_POST, $transactionCreate->getMethod());
    }

    private function createTransaction(
        $expirationDate,
        $referenceKey = null
    )
    {
        $customerMock = $this->getCustomerMock();

        $transaction =  new BoletoTransaction(
            [
                'amount'                 => 1337,
                'postback_url'           => 'example.com/postback',
                'customer'               => $customerMock,
                'boleto_expiration_date' => $expirationDate,
                'reference_key' => $referenceKey
            ]
        );

        return $transaction;
    }

    public function getCustomerMock()
    {
        $customerMock = $this->getMockBuilder('PagarMe\Sdk\Customer\Customer')
            ->disableOriginalConstructor()
            ->getMock();

        $customerMock->method('getBornAt')->willReturn('15071991');
        $customerMock->method('getDocumentNumber')->willReturn('10586649727');
        $customerMock->method('getEmail')->willReturn('eduardo@eduardo.com');
        $customerMock->method('getGender')->willReturn('M');
        $customerMock->method('getName')->willReturn('Eduardo Nascimento');
        $customerMock->method('getAddress')->willReturn(
            [
                'street'        => 'rua teste',
                'street_number' => 42,
                'neighborhood'  => 'centro',
                'zipcode'       => '01227200'
            ]
        );
        $customerMock->method('getPhone')->willReturn(
            [
                'ddi'    => 55,
                'ddd'    => 15,
                'number' => 987523421
            ]
        );

        return $customerMock;
    }

    /**
     * @test
     */
    public function mustPayloadContainSoftDescriptor()
    {

        $customerMock = $this->getCustomerMock();

        $transaction =  new BoletoTransaction(
            [
                'amount'                 => 1338,
                'postback_url'           => 'example.com/postback',
                'customer'               => $customerMock,
                'soft_descriptor'        => "Minha loja",
                'reference_key'           => null
            ]
        );

        $transactionCreate = new boletoTransactionCreate (
            $transaction
        );

        $this->assertEquals(
            [
                'amount'                 => 1338,
                'payment_method'         => 'boleto',
                'postback_url'           => 'example.com/postback',
                'boleto_expiration_date' => null,
                'customer' => [
                    'name'            => 'Eduardo Nascimento',
                    'born_at'         => '15071991',
                    'document_number' => '10586649727',
                    'email'           => 'eduardo@eduardo.com',
                    'sex'             => 'M',
                    'address' => [
                        'street'        => 'rua teste',
                        'street_number' => 42,
                        'neighborhood'  => 'centro',
                        'zipcode'       => '01227200',
                        'complementary' => null
                    ],
                    'phone' => [
                        'ddi'    => 55,
                        'ddd'    => 15,
                        'number' => 987523421
                    ]
                ],
                'metadata' => null,
                'async' => null,
                'boleto_instructions' => null,
                'soft_descriptor' => 'Minha loja',
                'reference_key' => null
            ],
            $transactionCreate->getPayload()
        );
    }
}
