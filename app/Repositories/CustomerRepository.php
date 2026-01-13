<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAllCustomers()
    {
        return Customer::all();
    }

    public function getCustomerById($customerId)
    {
        return Customer::findOrFail($customerId);
    }

    public function createCustomer(array $customerDetails)
    {
        return Customer::create($customerDetails);
    }

    public function updateCustomer($customerId, array $newDetails)
    {
        $customer = Customer::findOrFail($customerId);
        $customer->update($newDetails);
        return $customer;
    }

    public function deleteCustomer($customerId)
    {
        Customer::destroy($customerId);
    }
}
