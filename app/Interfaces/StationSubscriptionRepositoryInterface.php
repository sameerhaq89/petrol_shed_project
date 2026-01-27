<?php

namespace App\Interfaces;

interface StationSubscriptionRepositoryInterface
{
    public function getStationActiveSubscription($stationId);
    public function getStationSubscriptionHistory($stationId);
    public function createSubscription(array $data);
    public function updateSubscription($id, array $data);
    public function cancelSubscription($id);
    public function renewSubscription($id);
    public function checkSubscriptionValidity($stationId);
    public function getExpiringSubscriptions($days = 7);
}
