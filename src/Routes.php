<?php

namespace PagarMe;

use PagarMe\Anonymous;

class Routes
{
    public static function transactions()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return 'transactions';
        };

        $anonymous->details = static function ($id) {
            return "transactions/$id";
        };

        $anonymous->capture = static function ($id) {
            return "transactions/$id/capture";
        };

        $anonymous->refund = static function ($id) {
            return "transactions/$id/refund";
        };

        return $anonymous;
    }

    public static function customers()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return 'customers';
        };

        $anonymous->details = static function ($id) {
            return "customers/$id";
        };

        return $anonymous;
    }
}
