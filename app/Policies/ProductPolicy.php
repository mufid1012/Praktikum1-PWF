<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     * Hanya admin yang bisa edit, dan hanya data miliknya sendiri.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->role === 'admin' && $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * Hanya admin yang bisa delete, dan hanya data miliknya sendiri.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->role === 'admin' && $user->id === $product->user_id;
    }
}
