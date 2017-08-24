<?php

namespace PagarMe\SdkTest\Subscription\Request;

use PagarMe\Sdk\Subscription\Request\CardSubscriptionCreate;
use PagarMe\Sdk\SplitRule\SplitRuleCollection;
use PagarMe\Sdk\Recipient\Recipient;
use PagarMe\Sdk\RequestInterface;

class CardSubscriptionCreateTest extends \PHPUnit_Framework_TestCase
{
    const PATH   = 'subscriptions';

    const PLAN_ID             = 123;
    const PLAN_PAYMENT_METHOD = 'credit_card';

    const POSTBACK_URL   = 'http://myhost.com/postback';

    const CUSTOMER_NAME           = 'John Doe';
    const CUSTOMER_EMAIL          = 'john@test.com';
    const CUSTOMER_DOCUMENTNUMBER = '576981209';
    const CUSTOMER_BORN_AT        = '12031990';
    const CUSTOMER_GENDER         = 'm';

    const PHONE_DDD    = '11';
    const PHONE_NUMBER = '44445555';

    const ADDRESS_STREET       = 'Rua teste';
    const ADDRESS_STREETNUMBER = '123';
    const ADDRESS_NEIGHBORHOOD = 'Centro';
    const ADDRESS_ZIPCODE      = '01034020';

    const CARD_ID   = 123456;
    const CARD_HASH = 'FC1mH7XLFU5fjPAzDsP0ogeAQh3qXRpHzkIrgDz64lITBUGwio67zm';

    const SPLIT_RULE_RECIPIENT_ID_1 = 're_cj2wd5ul500d4946do7qtjrvk';
    const SPLIT_RULE_RECIPIENT_ID_2 = 're_cj2wd5u2600fecw6eytgcbkd0';
    const SPLIT_RULE_VALUE          = 50;

    private function getConfiguredPlanMockForPayloadTest()
    {
        $planMock = $this->getMockBuilder('PagarMe\Sdk\Plan\Plan')
            ->disableOriginalConstructor()
            ->getMock();
        $planMock->method('getId')->willReturn(self::PLAN_ID);

        return $planMock;
    }

    private function getConfiguredCustomerGenericMockForPayloadTest()
    {
        $customerMock = $this->getMockBuilder('PagarMe\Sdk\Customer\Customer')
            ->disableOriginalConstructor()
            ->getMock();

        $customerMock->method('getName')
            ->willReturn(self::CUSTOMER_NAME);
        $customerMock->method('getEmail')
            ->willReturn(self::CUSTOMER_EMAIL);
        $customerMock->method('getDocumentNumber')
            ->willReturn(self::CUSTOMER_DOCUMENTNUMBER);
        $customerMock->method('getBornAt')
            ->willReturn(self::CUSTOMER_BORN_AT);
        $customerMock->method('getGender')
            ->willReturn(self::CUSTOMER_GENDER);

        return $customerMock;
    }

    private function getConfiguredCustomerWithoutAddressAndPhoneMockForPayloadTest()
    {
        $customerMock = $this->getConfiguredCustomerGenericMockForPayloadTest();

        $customerMock->method('getAddress')
            ->willReturn(null);
        $customerMock->method('getPhone')
            ->willReturn(null);

        return $customerMock;
    }

    private function getConfiguredCustomerMockForPayloadTest()
    {
        $addressMock = $this->getConfiguredAddressMockForPayloadTest();
        $phoneMock = $this->getConfiguredPhoneMockForPayloadTest();

        $customerMock = $this->getConfiguredCustomerGenericMockForPayloadTest();

        $customerMock->method('getAddress')
            ->willReturn($addressMock);
        $customerMock->method('getPhone')
            ->willReturn($phoneMock);

        return $customerMock;
    }

    private function getConfiguredAddressMockForPayloadTest()
    {
        $addressMock = $this->getMockBuilder('PagarMe\Sdk\Customer\Address')
            ->disableOriginalConstructor()
            ->getMock();

        $addressMock->method('getStreet')
            ->willReturn(self::ADDRESS_STREET);
        $addressMock->method('getStreetNumber')
            ->willReturn(self::ADDRESS_STREETNUMBER);
        $addressMock->method('getNeighborhood')
            ->willReturn(self::ADDRESS_NEIGHBORHOOD);
        $addressMock->method('getZipcode')
            ->willReturn(self::ADDRESS_ZIPCODE);

        return $addressMock;
    }

    private function getConfiguredSplitRuleMockForPayloadTest($recipientId, $percentage)
    {
        $splitRule = $this->getMockBuilder('PagarMe\Sdk\SplitRule\SplitRule')
            ->disableOriginalConstructor()->getMock();

        $splitRule->method('getRecipient')
            ->willReturn(new Recipient(['id' => $recipientId]));
        $splitRule->method('getChargeProcessingFee')
            ->willReturn(true);
        $splitRule->method('getChargeRemainder')
            ->willReturn(true);
        $splitRule->method('getLiable')
            ->willReturn(true);

        if ($percentage) {
            $splitRule->method('getPercentage')
                ->willReturn(self::SPLIT_RULE_VALUE);
            $splitRule->method('getAmount')
                ->willReturn(null);
        } else {
            $splitRule->method('getAmount')
                ->willReturn(self::SPLIT_RULE_VALUE);
        }

        return $splitRule;
    }

    private function getConfiguredSplitRuleCollectionMockForPayloadTest($percentage = true)
    {
        $rules = new SplitRuleCollection();
        $rules[] = $this->getConfiguredSplitRuleMockForPayloadTest(self::SPLIT_RULE_RECIPIENT_ID_1, $percentage);
        $rules[] = $this->getConfiguredSplitRuleMockForPayloadTest(self::SPLIT_RULE_RECIPIENT_ID_2, $percentage);

        return $rules;
    }

    private function getConfiguredPhoneMockForPayloadTest()
    {
        $phoneMock = $this->getMockBuilder('PagarMe\Sdk\Customer\Phone')
            ->disableOriginalConstructor()
            ->getMock();

        $phoneMock->method('getDdd')->willReturn(self::PHONE_DDD);
        $phoneMock->method('getNumber')->willReturn(self::PHONE_NUMBER);

        return $phoneMock;
    }

    private function getDefaultPayloadWithoutCardInfo()
    {
        return [
            'plan_id'        => self::PLAN_ID,
            'payment_method' => self::PLAN_PAYMENT_METHOD,
            'metadata'       => $this->planMetadata(),
            'customer'       => [
                'name'            => self::CUSTOMER_NAME,
                'email'           => self::CUSTOMER_EMAIL,
                'document_number' => self::CUSTOMER_DOCUMENTNUMBER,
                'address'         => [
                    'street'        => self::ADDRESS_STREET,
                    'street_number' => self::ADDRESS_STREETNUMBER,
                    'neighborhood'  => self::ADDRESS_NEIGHBORHOOD,
                    'zipcode'       => self::ADDRESS_ZIPCODE
                ],
                'phone'           => [
                    'ddd'    => self::PHONE_DDD,
                    'number' => self::PHONE_NUMBER
                ],
                'born_at'         => self::CUSTOMER_BORN_AT,
                'gender'          => self::CUSTOMER_GENDER
            ],
            'postback_url' => self::POSTBACK_URL
        ];
    }

    private function getExpectedPayloadWithoutAddressAndPhone()
    {
        $payload = $this->getExpectedPayloadWithCardId();
        unset($payload['customer']['address'], $payload['customer']['phone']);
        return $payload;
    }

    private function getExpectedPayloadWithCardId()
    {
        return array_merge(
            $this->getDefaultPayloadWithoutCardInfo(),
            ['card_id' => self::CARD_ID]
        );
    }

    private function getExpectedPayloadWithCardHash()
    {
        return array_merge(
            $this->getDefaultPayloadWithoutCardInfo(),
            ['card_hash' => self::CARD_HASH]
        );
    }

    private function getExpectedPayloadWithSplitRulesAmount()
    {
        return array_merge(
            $this->getDefaultPayloadWithoutCardInfo(),
            [
                'card_id'     => self::CARD_ID,
                "split_rules" => [
                    [
                        "recipient_id"          => self::SPLIT_RULE_RECIPIENT_ID_1,
                        "amount"                => self::SPLIT_RULE_VALUE,
                        "liable"                => true,
                        "charge_processing_fee" => true,
                        "charge_remainder_fee"  => true
                    ],
                    [
                        "recipient_id"          => self::SPLIT_RULE_RECIPIENT_ID_2,
                        "amount"                => 50,
                        "liable"                => true,
                        "charge_processing_fee" => true,
                        "charge_remainder_fee"  => true
                    ]
                ]
            ]
        );
    }

    private function getExpectedPayloadWithSplitRulesPercentage()
    {
        return array_merge(
            $this->getDefaultPayloadWithoutCardInfo(),
            [
                'card_id'     => self::CARD_ID,
                "split_rules" => [
                    [
                        "recipient_id"          => self::SPLIT_RULE_RECIPIENT_ID_1,
                        "percentage"            => self::SPLIT_RULE_VALUE,
                        "liable"                => true,
                        "charge_processing_fee" => true,
                        "charge_remainder_fee"  => true
                    ],
                    [
                        "recipient_id"          => self::SPLIT_RULE_RECIPIENT_ID_2,
                        "percentage"            => 50,
                        "liable"                => true,
                        "charge_processing_fee" => true,
                        "charge_remainder_fee"  => true
                    ]
                ]
            ]
        );
    }

    /**
     * @test
     */
    public function mustPayloadBeCorrect()
    {
        $planMock = $this->getConfiguredPlanMockForPayloadTest();

        $cardMock = $this->getMockBuilder('PagarMe\Sdk\Card\Card')
            ->disableOriginalConstructor()
            ->getMock();
        $cardMock->method('getId')->willReturn(self::CARD_ID);

        $customerMock = $this->getConfiguredCustomerMockForPayloadTest();

        $cardSubscriptionCreateRequest = new CardSubscriptionCreate(
            $planMock,
            $cardMock,
            $customerMock,
            self::POSTBACK_URL,
            $this->planMetadata(),
            []
        );

        $this->assertEquals(
            $cardSubscriptionCreateRequest->getPayload(),
            $this->getExpectedPayloadWithCardId()
        );
    }

    /**
     * @test
     */
    public function mustPayloadWithSplitRuleAmountBeCorrect()
    {
        $planMock = $this->getConfiguredPlanMockForPayloadTest();

        $cardMock = $this->getMockBuilder('PagarMe\Sdk\Card\Card')
            ->disableOriginalConstructor()
            ->getMock();
        $cardMock->method('getId')->willReturn(self::CARD_ID);

        $customerMock = $this->getConfiguredCustomerMockForPayloadTest();

        $cardSubscriptionCreateRequest = new CardSubscriptionCreate(
            $planMock,
            $cardMock,
            $customerMock,
            self::POSTBACK_URL,
            $this->planMetadata(),
            ['split_rules' => $this->getConfiguredSplitRuleCollectionMockForPayloadTest(false)]
        );

        $this->assertEquals(
            $cardSubscriptionCreateRequest->getPayload(),
            $this->getExpectedPayloadWithSplitRulesAmount()
        );
    }

    /**
     * @test
     */
    public function mustPayloadWithSplitRulePercentageBeCorrect()
    {
        $planMock = $this->getConfiguredPlanMockForPayloadTest();

        $cardMock = $this->getMockBuilder('PagarMe\Sdk\Card\Card')
            ->disableOriginalConstructor()
            ->getMock();
        $cardMock->method('getId')->willReturn(self::CARD_ID);

        $customerMock = $this->getConfiguredCustomerMockForPayloadTest();

        $cardSubscriptionCreateRequest = new CardSubscriptionCreate(
            $planMock,
            $cardMock,
            $customerMock,
            self::POSTBACK_URL,
            $this->planMetadata(),
            ['split_rules' => $this->getConfiguredSplitRuleCollectionMockForPayloadTest()]
        );

        $this->assertEquals(
            $cardSubscriptionCreateRequest->getPayload(),
            $this->getExpectedPayloadWithSplitRulesPercentage()
        );
    }

    /**
     * @test
     */
    public function mustPayloadBeCorrectWithoutAddressAndPhone()
    {
        $planMock = $this->getConfiguredPlanMockForPayloadTest();

        $cardMock = $this->getMockBuilder('PagarMe\Sdk\Card\Card')
            ->disableOriginalConstructor()
            ->getMock();
        $cardMock->method('getId')->willReturn(self::CARD_ID);

        $customerMock = $this->getConfiguredCustomerWithoutAddressAndPhoneMockForPayloadTest();

        $cardSubscriptionCreateRequest = new CardSubscriptionCreate(
            $planMock,
            $cardMock,
            $customerMock,
            self::POSTBACK_URL,
            $this->planMetadata(),
            []
        );

        $this->assertEquals(
            $cardSubscriptionCreateRequest->getPayload(),
            $this->getExpectedPayloadWithoutAddressAndPhone()
        );
    }

    /**
     * @test
     */
    public function mustPayloadContainCardHash()
    {
        $planMock = $this->getConfiguredPlanMockForPayloadTest();

        $cardMock = $this->getMockBuilder('PagarMe\Sdk\Card\Card')
            ->disableOriginalConstructor()
            ->getMock();
        $cardMock->method('getHash')->willReturn(self::CARD_HASH);

        $customerMock = $this->getConfiguredCustomerMockForPayloadTest();

        $cardSubscriptionCreateRequest = new CardSubscriptionCreate(
            $planMock,
            $cardMock,
            $customerMock,
            self::POSTBACK_URL,
            $this->planMetadata(),
            []
        );

        $this->assertEquals(
            $cardSubscriptionCreateRequest->getPayload(),
            $this->getExpectedPayloadWithCardHash()
        );
    }

    private function planMetadata()
    {
        return [
            'foo' => 'bar',
            'a'   => 'b'
        ];
    }

    /**
     * @test
     */
    public function mustMethodBeCorrect()
    {
        $planMock = $this->getMockBuilder('PagarMe\Sdk\Plan\Plan')
            ->disableOriginalConstructor()
            ->getMock();
        $cardMock = $this->getMockBuilder('PagarMe\Sdk\Card\Card')
            ->disableOriginalConstructor()
            ->getMock();
        $cardMock->method('getId')->willReturn(self::CARD_ID);

        $customerMock = $this->getMockBuilder('PagarMe\Sdk\Customer\Customer')
            ->disableOriginalConstructor()
            ->getMock();

        $cardSubscriptionCreateRequest = new CardSubscriptionCreate(
            $planMock,
            $cardMock,
            $customerMock,
            null,
            [],
            []
        );

        $this->assertEquals(
            $cardSubscriptionCreateRequest->getMethod(),
            RequestInterface::HTTP_POST
        );
    }

    /**
     * @test
     */
    public function mustPathBeCorrect()
    {
        $planMock = $this->getMockBuilder('PagarMe\Sdk\Plan\Plan')
            ->disableOriginalConstructor()
            ->getMock();

        $cardMock = $this->getMockBuilder('PagarMe\Sdk\Card\Card')
            ->disableOriginalConstructor()
            ->getMock();
        $cardMock->method('getId')->willReturn(self::CARD_ID);

        $customerMock = $this->getMockBuilder('PagarMe\Sdk\Customer\Customer')
            ->disableOriginalConstructor()
            ->getMock();

        $cardSubscriptionCreateRequest = new CardSubscriptionCreate(
            $planMock,
            $cardMock,
            $customerMock,
            null,
            [],
            []
        );

        $this->assertEquals(
            $cardSubscriptionCreateRequest->getPath(),
            self::PATH
        );
    }
}
