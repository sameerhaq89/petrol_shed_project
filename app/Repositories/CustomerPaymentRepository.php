<?php

namespace App\Repositories;

use App\Interfaces\CustomerPaymentRepositoryInterface;
use App\Models\CustomerPayment;

class CustomerPaymentRepository implements CustomerPaymentRepositoryInterface
{
    public function getAllPayments()
    {
        return CustomerPayment::all();
    }

    public function createPayment(array $paymentDetails)
    {
        return CustomerPayment::create($paymentDetails);
    }
}
