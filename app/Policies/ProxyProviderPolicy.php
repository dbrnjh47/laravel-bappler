<?php

namespace App\Policies;

use App\Models\ProxyProvider;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProxyProviderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['IT | Proxy Provider | ReadOnly', 'IT | Proxy Provider | FullAccess']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProxyProvider $proxyProvider): bool
    {
        return $user->hasAnyPermission(['IT | Proxy Provider | ReadOnly', 'IT | Proxy Provider | FullAccess']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('IT | Proxy Provider | FullAccess');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProxyProvider $proxyProvider): bool
    {
        return $user->hasPermissionTo('IT | Proxy Provider | FullAccess');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProxyProvider $proxyProvider): bool
    {
        return $user->hasPermissionTo('IT | Proxy Provider | FullAccess');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProxyProvider $proxyProvider): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProxyProvider $proxyProvider): bool
    {
        return $user->hasPermissionTo('IT | Proxy Provider | FullAccess');
    }
}
