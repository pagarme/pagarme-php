<?php

namespace PagarMe\SdkTests\Customer;

class CustomerBuilderTest extends \PHPUnit_Framework_TestCase
{
    use \PagarMe\Sdk\Customer\CustomerBuilder;

    /**
     * @test
     */
    public function mustCreateCustomerCorrectly()
    {
        $payload = '{"object":"customer","document_number":"25123317171","document_type":"cpf","name":"John Doe","email":"john@test.com","born_at":null,"gender":null,"date_created":"2016-12-28T19:38:28.618Z","id":122444,"addresses":[{"object":"address","street":"Rua Teste","complementary":null,"street_number":"123","neighborhood":"Centro","city":null,"state":null,"zipcode":"01034020","country":null,"id":68136}],"phones":[{"object":"phone","ddi":"55","ddd":"11","number":"44445555","id":65844}]}';

        $customer = $this->buildCustomer(json_decode($payload));

        $this->assertInstanceOf('PagarMe\Sdk\Customer\Customer', $customer);
        $this->assertInstanceOf('\DateTime', $customer->getDateCreated());
    }

    /**
     * @test
     */
    public function mustCreateCustomerCorrectlyFromResponse()
    {

        $response = '{"phone":{"object":"phone","ddi":"55","ddd":"11","number":"987654321","id":121118},"address":{"object":"address","street":"R.Dr.GeraldoCamposMoreira","complementary":null,"street_number":"240","neighborhood":"CidadeMonções","city":"SãoPaulo","state":"SP","zipcode":"04571020","country":"Brasil","id":117699},"customer":{"object":"customer","id":76758,"external_id":null,"type":null,"country":null,"document_number":"18152564000105","document_type":"cnpj","name":"AardvarkdaSilva","email":"aardvark.silva@gmail.com","phones":null,"born_at":"1985-11-02T03:00:00.000Z","birthday":null,"gender":"M","date_created":"2016-06-29T16:18:23.544Z","documents":[]}}';

        $data = json_decode($response);

        $customer = $this->buildCustomerFromResponse($data->customer, $data->address, $data->phone);

        $this->assertInstanceOf('PagarMe\Sdk\Customer\Customer', $customer);
        $this->assertInstanceOf('\DateTime', $customer->getDateCreated());
    }

    /**
     * @test
     */
    public function mustNotCreateCustomerFromResponse()
    {
        $response = '{"phone":{"object":"phone","ddi":"55","ddd":"11","number":"987654321","id":121118},"address":{"object":"address","street":"R.Dr.GeraldoCamposMoreira","complementary":null,"street_number":"240","neighborhood":"CidadeMonções","city":"SãoPaulo","state":"SP","zipcode":"04571020","country":"Brasil","id":117699},"customer":null}';

        $data = json_decode($response);

        $customer = $this->buildCustomerFromResponse($data->customer, $data->address, $data->phone);

        $this->assertNull($customer);
    }
}
