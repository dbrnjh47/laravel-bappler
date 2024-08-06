<?php

namespace App\Policies;

use App\Models\GoogleMyBusinessReview;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GoogleMyBusinessReviewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['CRM | Reviews | ReadOnly', 'CRM | Reviews | FullAccess']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GoogleMyBusinessReview $googleMyBusinessReview): bool
    {
        return $user->hasAnyPermission(['CRM | Reviews | ReadOnly', 'CRM | Reviews | FullAccess']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('CRM | Reviews | FullAccess');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GoogleMyBusinessReview $googleMyBusinessReview): bool
    {
        return $user->hasPermissionTo('CRM | Reviews | FullAccess');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GoogleMyBusinessReview $googleMyBusinessReview): bool
    {
        return $user->hasPermissionTo('CRM | Reviews | FullAccess');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GoogleMyBusinessReview $googleMyBusinessReview): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GoogleMyBusinessReview $googleMyBusinessReview): bool
    {
        return $user->hasPermissionTo('CRM | Reviews | FullAccess');
    }
}
