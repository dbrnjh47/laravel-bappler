<?php

namespace App\Policies;

use App\Models\BrowserProfile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BrowserProfilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['IT | Browser Profile | ReadOnly', 'IT | Browser Profile | FullAccess']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BrowserProfile $browserProfile): bool
    {
        return $user->hasAnyPermission(['IT | Browser Profile | ReadOnly', 'IT | Browser Profile | FullAccess']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('IT | Browser Profile | FullAccess');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BrowserProfile $browserProfile): bool
    {
        return $user->hasPermissionTo('IT | Browser Profile | FullAccess');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BrowserProfile $browserProfile): bool
    {
        return $user->hasPermissionTo('IT | Browser Profile | FullAccess');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BrowserProfile $browserProfile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BrowserProfile $browserProfile): bool
    {
        return $user->hasPermissionTo('IT | Browser Profile | FullAccess');
    }
}
