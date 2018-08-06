<?php
namespace PagarMe\Test\Mocks;

class TransactionListMock
{
    public static function mock()
    {
        return '[
    {
        "object": "transaction",
        "status": "authorized",
        "refuse_reason": null,
        "status_reason": "acquirer",
        "acquirer_response_code": "0000",
        "acquirer_name": "pagarme",
        "acquirer_id": "58a49047916d40fa539ba926",
        "authorization_code": "737870",
        "soft_descriptor": null,
        "tid": 1836030,
        "nsu": 1836030,
        "date_created": "2017-08-15T16:14:58.903Z",
        "date_updated": "2017-08-15T16:14:59.179Z",
        "amount": 10000,
        "authorized_amount": 10000,
        "paid_amount": 0,
        "refunded_amount": 0,
        "installments": 1,
        "id": 1836030,
        "cost": 0,
        "card_holder_name": "Morpheus Fishburne",
        "card_last_digits": "1111",
        "card_first_digits": "411111",
        "card_brand": "visa",
        "card_pin_mode": null,
        "postback_url": null,
        "payment_method": "credit_card",
        "capture_method": "ecommerce",
        "antifraud_score": null,
        "boleto_url": null,
        "boleto_barcode": null,
        "boleto_expiration_date": null,
        "referer": "api_key",
        "ip": "10.2.13.68",
        "subscription_id": null,
        "phone": null,
        "address": null,
        "customer": {
            "object": "customer",
            "id": 234275,
            "external_id": "#3311",
            "type": "individual",
            "country": "br",
            "document_number": null,
            "document_type": "cpf",
            "name": "Morpheus Fishburne",
            "email": "mopheus@nabucodonozor.com",
            "phone_numbers": [
                "+5511999998888",
                "+5511888889999"
            ],
            "born_at": null,
            "birthday": "1965-01-01",
            "gender": null,
            "date_created": "2017-08-15T16:14:58.815Z",
            "documents": [
                {
                    "object": "document",
                    "id": "doc_cj6dsh3bj0mlj6m6dmm39mqmb",
                    "type": "cpf",
                    "number": "00000000000"
                }
            ]
        },
        "billing": {
            "address": {
                "object": "address",
                "street": "Rua Matrix",
                "complementary": null,
                "street_number": "9999",
                "neighborhood": "Rio Cotia",
                "city": "Cotia",
                "state": "sp",
                "zipcode": "06714360",
                "country": "br",
                "id": 146613
            },
            "object": "billing",
            "id": 35,
            "name": "Trinity Moss"
        },
        "shipping": {
            "address": {
                "object": "address",
                "street": "Rua Matrix",
                "complementary": null,
                "street_number": "9999",
                "neighborhood": "Rio Cotia",
                "city": "Cotia",
                "state": "sp",
                "zipcode": "06714360",
                "country": "br",
                "id": 146614
            },
            "object": "shipping",
            "id": 29,
            "name": "Neo Reeves",
            "fee": 3311,
            "delivery_date": "2000-12-21",
            "expedited": true
        },
        "items": [],
        "card": {
            "object": "card",
            "id": "card_cj6dsh3d90mlk6m6d951q4wil",
            "date_created": "2017-08-15T16:14:58.894Z",
            "date_updated": "2017-08-15T16:14:58.894Z",
            "brand": "visa",
            "holder_name": "Morpheus Fishburne",
            "first_digits": "411111",
            "last_digits": "1111",
            "country": "UNITED STATES",
            "fingerprint": "3ace8040fba3f5c3a0690ea7964ea87d97123437",
            "valid": null,
            "expiration_date": "0922"
        },
        "split_rules": [
            {
                "object": "split_rule",
                "id": "sr_cj6dsh3eg0mlm6m6dh6r036bk",
                "liable": true,
                "amount": null,
                "percentage": 50,
                "recipient_id": "re_cj6dsgxiz0mlh6m6d6e20rvuy",
                "charge_remainder": false,
                "charge_processing_fee": true,
                "date_created": "2017-08-15T16:14:58.936Z",
                "date_updated": "2017-08-15T16:14:58.936Z"
            },
            {
                "object": "split_rule",
                "id": "sr_cj6dsh3ef0mll6m6dxk40wxw8",
                "liable": true,
                "amount": null,
                "percentage": 50,
                "recipient_id": "re_cj6dsc0i90o56yy6erybyxs9p",
                "charge_remainder": true,
                "charge_processing_fee": true,
                "date_created": "2017-08-15T16:14:58.936Z",
                "date_updated": "2017-08-15T16:14:58.936Z"
            }
        ],
        "antifraud_metadata": {},
        "reference_key": null,
        "metadata": {}
    },
    {
        "object": "transaction",
        "status": "authorized",
        "refuse_reason": null,
        "status_reason": "acquirer",
        "acquirer_response_code": "0000",
        "acquirer_name": "pagarme",
        "acquirer_id": "58a49047916d40fa539ba926",
        "authorization_code": "688274",
        "soft_descriptor": null,
        "tid": 1835912,
        "nsu": 1835912,
        "date_created": "2017-08-15T15:58:31.733Z",
        "date_updated": "2017-08-15T15:58:53.177Z",
        "amount": 10000,
        "authorized_amount": 10000,
        "paid_amount": 0,
        "refunded_amount": 1200,
        "installments": 1,
        "id": 1835912,
        "cost": 0,
        "card_holder_name": "Morpheus Fishburne",
        "card_last_digits": "1111",
        "card_first_digits": "411111",
        "card_brand": "visa",
        "card_pin_mode": null,
        "postback_url": null,
        "payment_method": "credit_card",
        "capture_method": "ecommerce",
        "antifraud_score": null,
        "boleto_url": null,
        "boleto_barcode": null,
        "boleto_expiration_date": null,
        "referer": "api_key",
        "ip": "10.2.14.195",
        "subscription_id": null,
        "phone": null,
        "address": null,
        "customer": {
            "object": "customer",
            "id": 234265,
            "external_id": "#3311",
            "type": "individual",
            "country": "br",
            "document_number": null,
            "document_type": "cpf",
            "name": "Morpheus Fishburne",
            "email": "mopheus@nabucodonozor.com",
            "phone_numbers": [
                "+5511999998888",
                "+5511888889999"
            ],
            "born_at": null,
            "birthday": "1965-01-01",
            "gender": null,
            "date_created": "2017-08-15T15:58:31.636Z",
            "documents": [
                {
                    "object": "document",
                    "id": "doc_cj6drvxlw0lqn696dtbbwri6y",
                    "type": "cpf",
                    "number": "00000000000"
                }
            ]
        },
        "billing": {
            "address": {
                "object": "address",
                "street": "Rua Matrix",
                "complementary": null,
                "street_number": "9999",
                "neighborhood": "Rio Cotia",
                "city": "Cotia",
                "state": "sp",
                "zipcode": "06714360",
                "country": "br",
                "id": 146609
            },
            "object": "billing",
            "id": 34,
            "name": "Trinity Moss"
        },
        "shipping": {
            "address": {
                "object": "address",
                "street": "Rua Matrix",
                "complementary": null,
                "street_number": "9999",
                "neighborhood": "Rio Cotia",
                "city": "Cotia",
                "state": "sp",
                "zipcode": "06714360",
                "country": "br",
                "id": 146610
            },
            "object": "shipping",
            "id": 28,
            "name": "Neo Reeves",
            "fee": 3311,
            "delivery_date": "2000-12-21",
            "expedited": true
        },
        "items": [
            {
                "object": "item",
                "id": "1",
                "title": "Red pill",
                "unit_price": 12000,
                "quantity": 1,
                "category": null,
                "tangible": true,
                "venue": null,
                "date": null
            },
            {
                "object": "item",
                "id": "a123",
                "title": "Blue pill",
                "unit_price": 12000,
                "quantity": 1,
                "category": null,
                "tangible": true,
                "venue": null,
                "date": null
            }
        ],
        "card": {
            "object": "card",
            "id": "card_cj6drvxnm0lqo696dirob3ibk",
            "date_created": "2017-08-15T15:58:31.714Z",
            "date_updated": "2017-08-15T15:58:32.098Z",
            "brand": "visa",
            "holder_name": "Morpheus Fishburne",
            "first_digits": "411111",
            "last_digits": "1111",
            "country": "UNITED STATES",
            "fingerprint": "3ace8040fba3f5c3a0690ea7964ea87d97123437",
            "valid": true,
            "expiration_date": "0922"
        },
        "split_rules": null,
        "antifraud_metadata": {},
        "reference_key": null,
        "metadata": {}
    }
	]';
    }
}
