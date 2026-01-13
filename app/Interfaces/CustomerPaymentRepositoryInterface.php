<?php

namespace App\Interfaces;

interface CustomerPaymentRepositoryInterface
{
    public function getAllPayments();
    public function createPayment(array $paymentDetails);
}
