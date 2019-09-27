<?php

namespace App\Interfaces;

interface PaymentServiceInterface
{

    function processPayment($order_data);

    function contactApiProvider($order_data);
}
