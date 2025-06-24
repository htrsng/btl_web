<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Order $order)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Order $order)
    {
        return $user->role === 'admin';
    }
}
