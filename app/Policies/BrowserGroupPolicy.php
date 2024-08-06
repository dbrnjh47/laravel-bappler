<?php

namespace App\Policies;

use App\Models\BrowserGroup;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BrowserGroupPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['IT | Browser Group | ReadOnly', 'IT | Browser Group | FullAccess']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BrowserGroup $browserGroup): bool
    {
        return $user->hasAnyPermission(['IT | Browser Group | ReadOnly', 'IT | Browser Group | FullAccess']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('IT | Browser Group | FullAccess');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BrowserGroup $browserGroup): bool
    {
        return $user->hasPermissionTo('IT | Browser Group | FullAccess');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BrowserGroup $browserGroup): bool
    {
        return $user->hasPermissionTo('IT | Browser Group | FullAccess');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BrowserGroup $browserGroup): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BrowserGroup $browserGroup): bool
    {
        return $user->hasPermissionTo('IT | Browser Group | FullAccess');
    }
}
