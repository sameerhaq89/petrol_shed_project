<?php

namespace App\Interfaces;

interface CustomerRepositoryInterface
{
    public function getAllCustomers();
    public function getCustomerById($customerId);
    public function createCustomer(array $customerDetails);
    public function updateCustomer($customerId, array $newDetails);
    public function deleteCustomer($customerId);
}
