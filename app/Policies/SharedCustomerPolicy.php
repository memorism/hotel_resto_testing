<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SharedCustomer;

class SharedCustomerPolicy
{
    public function view(User $user, SharedCustomer $customer): bool
    {
        if ($user->usertype === 'admin') {
            return true;
        }

        if ($user->usertype === 'hotel') {
            return $customer->hotelBookings()->where('hotel_id', $user->hotel_id)->exists();
        }

        if ($user->usertype === 'resto') {
            return $customer->restoOrders()->where('resto_id', $user->resto_id)->exists();
        }

        return false;
    }
}
