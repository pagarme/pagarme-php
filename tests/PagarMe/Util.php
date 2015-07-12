<?php

class UtilTest extends PagarMeTestCase
{
    public function testIsList()
    {
        $arr1 = '123';
        $arr2 = array('abc' => 'bcd', '456' => 'bcd');
        $arr3 = array('abc', 'bcd', 'def');

        $this->assertFalse(Pagarme\Util::isList($arr1));    
        $this->assertFalse(Pagarme\Util::isList($arr2));    
        $this->assertTrue(Pagarme\Util::isList($arr3));    
    }

    public function testCamelCase()
    {
        $str = 'getPhones';
        $str2 = 'getBoletoUrl';
        $str3 = 'BoletoUrl';
        $str4 = 'Phone';

        $this->assertEqual(Pagarme\Util::fromCamelCase($str), 'get_phones');
        $this->assertEqual(Pagarme\Util::fromCamelCase($str2), 'get_boleto_url');
        $this->assertEqual(Pagarme\Util::fromCamelCase($str3), 'boleto_url');
        $this->assertEqual(Pagarme\Util::fromCamelCase($str4), 'phone');
    }

    public function testConvertToarray() {
        $obj = self::createPagarMeObject();
        $arr = Pagarme\Util::convertPagarMeObjectToarray($obj);

        $this->assertTrue(is_array($arr));
        $this->assertTrue(is_array($arr['customer']));
        $this->assertTrue($arr['customer']['address']['street'] == 'asdas');
    }

    public function testConvertToPagarMeObject() {
        $response = array("status"=> "paid",
            "object" => 'transaction',
            "refuse_reason" => null,
            "date_created" => "2013-09-26T03:19:36.000Z",
            "amount" => 1590,
            "installments" => 1,
            "id" => 1379,
            "card_holder_name" => "Jose da Silva",
            "card_last_digits" => "4448",
            "card_brand" => "visa",
            "postback_url" => null,
            "payment_method" => "credit_card",
            "customer" => array(
                'object' => 'customer',
                "document_number" => "51472745531",
                'address' => array(
                    'object' => "address",
                    'street' => 'asdas'
                )
            ));

        $obj = Pagarme\Util::convertToPagarMeObject($response);

        $this->assertTrue($obj instanceof Pagarme\Transaction);
        $this->assertTrue($obj->customer instanceof Pagarme\Customer);
        $this->assertTrue($obj->customer->address instanceof Pagarme\Address);
    }
}

?>
