<?php


namespace App\Service\Payment;


class PaymentFactory
{
    public static function createPayment()
    {
        return new PaymentCash();
    }
}