<?php

namespace App\Policies;

use App\Models\CraigslistPost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CraigslistPostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['IT | Craigslist Post | ReadOnly', 'IT | Craigslist Post | FullAccess']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CraigslistPost $craigslistPost): bool
    {
        return $user->hasAnyPermission(['IT | Craigslist Post | ReadOnly', 'IT | Craigslist Post | FullAccess']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('IT | Craigslist Post | FullAccess');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CraigslistPost $craigslistPost): bool
    {
        return $user->hasPermissionTo('IT | Craigslist Post | FullAccess');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CraigslistPost $craigslistPost): bool
    {
        return $user->hasPermissionTo('IT | Craigslist Post | FullAccess');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CraigslistPost $craigslistPost): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CraigslistPost $craigslistPost): bool
    {
        return $user->hasPermissionTo('IT | Craigslist Post | FullAccess');
    }
}
