<?php

namespace App\Policies;

use App\Models\CraigslistPostTemplate;
use App\Models\User;
use App\Models\BankCard;
use Illuminate\Auth\Access\Response;

class CraigslistPostTemplatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['IT | Craigslist Post Template | ReadOnly', 'IT | Craigslist Post Template | FullAccess']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CraigslistPostTemplate $craigslistPostTemplate): bool
    {
        return $user->hasAnyPermission(['IT | Craigslist Post Template | ReadOnly', 'IT | Craigslist Post Template | FullAccess']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('IT | Craigslist Post Template | FullAccess');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CraigslistPostTemplate $craigslistPostTemplate): bool
    {
        return $user->hasPermissionTo('IT | Craigslist Post Template | FullAccess');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CraigslistPostTemplate $craigslistPostTemplate): bool
    {
        return $user->hasPermissionTo('IT | Craigslist Post Template | FullAccess');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CraigslistPostTemplate $craigslistPostTemplate): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CraigslistPostTemplate $craigslistPostTemplate): bool
    {
        return $user->hasPermissionTo('IT | Craigslist Post Template | FullAccess');
    }
}
