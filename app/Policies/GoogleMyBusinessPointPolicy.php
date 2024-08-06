<?php

namespace App\Policies;

use App\Models\GoogleMyBusinessPoint;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GoogleMyBusinessPointPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['Marketing | GMB Accounts Map | ReadOnly', 'Marketing | GMB Accounts Map | FullAccess']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GoogleMyBusinessPoint $googleMyBusinessPoint): bool
    {
        return $user->hasAnyPermission(['Marketing | GMB Accounts Map | ReadOnly', 'Marketing | GMB Accounts Map | FullAccess']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Marketing | GMB Accounts Map | FullAccess');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GoogleMyBusinessPoint $googleMyBusinessPoint): bool
    {
        return $user->hasPermissionTo('Marketing | GMB Accounts Map | FullAccess');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GoogleMyBusinessPoint $googleMyBusinessPoint): bool
    {
        return $user->hasPermissionTo('Marketing | GMB Accounts Map | FullAccess');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GoogleMyBusinessPoint $googleMyBusinessPoint): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GoogleMyBusinessPoint $googleMyBusinessPoint): bool
    {
        return $user->hasPermissionTo('Marketing | GMB Accounts Map | FullAccess');
    }
}
