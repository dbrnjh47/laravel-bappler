<?php

namespace App\Policies;

use App\Models\NamecheapAccount;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NamecheapAccountPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['IT | Domain Registrars | ReadOnly', 'IT | Domain Registrars | FullAccess']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, NamecheapAccount $namecheapAccount): bool
    {
        return $user->hasAnyPermission(['IT | Domain Registrars | ReadOnly', 'IT | Domain Registrars | FullAccess']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('IT | Domain Registrars | FullAccess');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, NamecheapAccount $namecheapAccount): bool
    {
        return $user->hasPermissionTo('IT | Domain Registrars | FullAccess');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, NamecheapAccount $namecheapAccount): bool
    {
        return $user->hasPermissionTo('IT | Domain Registrars | FullAccess');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, NamecheapAccount $namecheapAccount): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, NamecheapAccount $namecheapAccount): bool
    {
        return $user->hasPermissionTo('IT | Domain Registrars | FullAccess');
    }
}
