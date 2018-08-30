<?php

namespace PagarMe;

use PagarMe\Anonymous;

class Routes
{
    /**
     * @return \Pagarme\Anonymous
     */
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

    /**
     * @return \PagarMe\Anonymous
     */
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

    /**
     * @return \PagarMe\Anonymous
     */
    public static function cards()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return 'cards';
        };

        $anonymous->details = static function ($id) {
            return "cards/$id";
        };

        return $anonymous;
    }

    /**
     * @return \PagarMe\Anonymous
     */
    public static function recipients()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return 'recipients';
        };

        $anonymous->details = static function ($id) {
            return "recipients/$id";
        };

        $anonymous->balance = static function ($id) {
            return "recipients/$id/balance";
        };

        $anonymous->balanceOperations = static function ($id) {
            return "recipients/$id/balance/operations";
        };

        $anonymous->balanceOperation = static function ($recipientId, $balanceOperationId) {
            return "recipients/$recipientId/balance/operations/$balanceOperationId";
        };

        return $anonymous;
    }

    /**
     * @return \PagarMe\Anonymous
     */
    public static function bankAccounts()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return 'bank_accounts';
        };

        $anonymous->details = static function ($id) {
            return "bank_accounts/$id";
        };

        return $anonymous;
    }

    /**
     * @return \PagarMe\Anonymous
     */
    public static function plans()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return 'plans';
        };

        $anonymous->details = static function ($id) {
            return "plans/$id";
        };

        return $anonymous;
    }

    /**
     * @return \PagarMe\Anonymous
     */
    public static function bulkAnticipations()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function ($recipientId) {
            return "recipients/$recipientId/bulk_anticipations";
        };

        $anonymous->limits = static function ($recipientId) {
            return "recipients/$recipientId/bulk_anticipations/limits";
        };

        $anonymous->confirm = static function ($recipientId, $bulkAnticipationId) {
            return "recipients/$recipientId/bulk_anticipations/$bulkAnticipationId/confirm";
        };

        $anonymous->cancel = static function ($recipientId, $bulkAnticipationId) {
            return "recipients/$recipientId/bulk_anticipations/$bulkAnticipationId/cancel";
        };

        $anonymous->delete = static function ($recipientId, $bulkAnticipationId) {
            return "recipients/$recipientId/bulk_anticipations/$bulkAnticipationId";
        };

        return $anonymous;
    }

    /**
     * @return \PagarMe\Anonymous
     */
    public static function paymentLinks()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return 'payment_links';
        };

        $anonymous->details = static function ($paymentLinkId) {
            return "payment_links/$paymentLinkId";
        };

        $anonymous->cancel = static function ($paymentLinkId) {
            return "payment_links/$paymentLinkId/cancel";
        };

        return $anonymous;
    }
}
