<?php

namespace App\Policies;

use App\Models\BankCard;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BankCardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['IT | Bank Card | ReadOnly', 'IT | Bank Card | FullAccess']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BankCard $bankCard): bool
    {
        return $user->hasAnyPermission(['IT | Bank Card | ReadOnly', 'IT | Bank Card | FullAccess']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('IT | Bank Card | FullAccess');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BankCard $bankCard): bool
    {
        return $user->hasPermissionTo('IT | Bank Card | FullAccess');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BankCard $bankCard): bool
    {
        return $user->hasPermissionTo('IT | Bank Card | FullAccess');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BankCard $bankCard): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BankCard $bankCard): bool
    {
        return $user->hasPermissionTo('IT | Bank Card | FullAccess');
    }
}
