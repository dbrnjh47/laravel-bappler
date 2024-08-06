<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\BrowserGroup;
use App\Models\Role;
use App\Models\User;
use App\Models\Email;
use App\Models\Proxy;
use App\Models\Domain;
use App\Models\Contact;
use App\Models\Request;
use App\Models\Permission;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Models\ProxyProvider;
use App\Policies\EmailPolicy;
use App\Policies\ProxyPolicy;
use App\Models\BrowserProfile;
use App\Policies\DomainPolicy;
use App\Policies\ContactPolicy;
use App\Policies\RequestPolicy;
use App\Models\NamecheapAccount;
use App\Policies\PermissionPolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\GoogleMyBusinessPoint;
use App\Policies\ProxyProviderPolicy;
use App\Models\GoogleMyBusinessReview;
use App\Policies\BrowserGroupPolicy;
use App\Policies\BrowserProfilePolicy;
use App\Policies\NamecheapAccountPolicy;
use App\Policies\GoogleMyBusinessPointPolicy;
use App\Policies\GoogleMyBusinessReviewPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //General
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,

        //IT
        NamecheapAccountPolicy::class => NamecheapAccount::class,
        DomainPolicy::class => Domain::class,
        EmailPolicy::class => Email::class,

        ProxyPolicy::class => Proxy::class,
        ProxyProviderPolicy::class => ProxyProvider::class,

        BrowserGroupPolicy::class => BrowserGroup::class,
        BrowserProfilePolicy::class => BrowserProfile::class,

        //Marketing
        RequestPolicy::class => Request::class,
        GoogleMyBusinessPointPolicy::class => GoogleMyBusinessPoint::class,

        //CRM
        GoogleMyBusinessReviewPolicy::class => GoogleMyBusinessReview::class,
        ContactPolicy::class => Contact::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //Allow all access for role Admin
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });
    }
}
