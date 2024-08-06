<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создание пользователя
        $admin = User::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Admin',
                'email' => 'admin@bappler.com',
                'password' => Hash::make('bappler13579'),
            ]
        );

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleManager = Role::create(['name' => 'Manager']);
        $roleUser = Role::create(['name' => 'User']);

        $admin->assignRole($roleAdmin);

        $pGeneralRolesRO = Permission::create(['name' => 'General | Roles | ReadOnly']);
        $pGeneralRolesFA = Permission::create(['name' => 'General | Roles | FullAccess']);
        $pGeneralPermissionsRO = Permission::create(['name' => 'General | Permissions | ReadOnly']);
        $pGeneralPermissionsFA = Permission::create(['name' => 'General | Permissions | FullAccess']);
        $pGeneralUsersRO = Permission::create(['name' => 'General | Users | ReadOnly']);
        $pGeneralUsersFA = Permission::create(['name' => 'General | Users | FullAccess']);

        $pITDomainRegistrarsRO = Permission::create(['name' => 'IT | Domain Registrars | ReadOnly']);
        $pITDomainRegistrarsFA = Permission::create(['name' => 'IT | Domain Registrars | FullAccess']);
        $pITDomainsRO = Permission::create(['name' => 'IT | Domains | ReadOnly']);
        $pITDomainsFA = Permission::create(['name' => 'IT | Domains | FullAccess']);
        $pITEmailsRO = Permission::create(['name' => 'IT | Emails | ReadOnly']);
        $pITEmailsFA = Permission::create(['name' => 'IT | Emails | FullAccess']);

        $pMarketingVisitsRO = Permission::create(['name' => 'Marketing | Visits | ReadOnly']);
        $pMarketingVisitsFA = Permission::create(['name' => 'Marketing | Visits | FullAccess']);
        $pMarketingGMBAccountsMapRO = Permission::create(['name' => 'Marketing | GMB Accounts Map | ReadOnly']);
        $pMarketingGMBAccountsMapFA = Permission::create(['name' => 'Marketing | GMB Accounts Map | FullAccess']);

        $pCRMReviewsRO = Permission::create(['name' => 'CRM | Reviews | ReadOnly']);
        $pCRMReviewsFA = Permission::create(['name' => 'CRM | Reviews | FullAccess']);
        $pCRMContactsRO = Permission::create(['name' => 'CRM | Contacts | ReadOnly']);
        $pCRMContactsFA = Permission::create(['name' => 'CRM | Contacts | FullAccess']);

        $roleManager->givePermissionTo([
            $pGeneralRolesRO,
            $pGeneralPermissionsRO,
            $pGeneralUsersRO,
            $pITDomainRegistrarsFA,
            $pITDomainsFA,
            $pITEmailsFA,
            $pMarketingVisitsFA,
            $pMarketingGMBAccountsMapFA,
            $pCRMReviewsFA,
            $pCRMContactsFA,
        ]);


        $roleUser->givePermissionTo([
            $pMarketingVisitsFA,
            $pMarketingGMBAccountsMapFA,
            $pCRMReviewsFA,
            $pCRMContactsFA,
        ]);


        // Proxy

        $this->call([ProxyProviderSeeder::class, ProxySeeder::class, ProxyConnectionSeeder::class]);
        // $this->call(ProxySeeder::class, [$roleAdmin, $roleManager, $roleUser]);

        $readOnly = Permission::create(['name' => 'IT | Proxy Provider | ReadOnly']);
        $fullAccess = Permission::create(['name' => 'IT | Proxy Provider | FullAccess']);

        $roleManager->givePermissionTo($fullAccess);

        $readOnly = Permission::create(['name' => 'IT | Proxy | ReadOnly']);
        $fullAccess = Permission::create(['name' => 'IT | Proxy | FullAccess']);

        $roleManager->givePermissionTo($fullAccess);

        // Browser

        $this->call([BrowserGroupSeeder::class, BrowserProfileSeeder::class]);

        $readOnly = Permission::create(['name' => 'IT | Browser Group | ReadOnly']);
        $fullAccess = Permission::create(['name' => 'IT | Browser Group | FullAccess']);

        $roleManager->givePermissionTo($fullAccess);

        $readOnly = Permission::create(['name' => 'IT | Browser Profile | ReadOnly']);
        $fullAccess = Permission::create(['name' => 'IT | Browser Profile | FullAccess']);

        $roleManager->givePermissionTo($fullAccess);

        //

        $this->call([BankCardSeeder::class]);

        $readOnly = Permission::create(['name' => 'IT | Bank Card | ReadOnly']);
        $fullAccess = Permission::create(['name' => 'IT | Bank Card | FullAccess']);

        //

        $this->call([CraigslistPostSeeder::class]);

        $readOnly = Permission::create(['name' => 'IT | Craigslist Post | ReadOnly']);
        $fullAccess = Permission::create(['name' => 'IT | Craigslist Post | FullAccess']);

        $permission_cr_post = Permission::create(['name' => 'IT | Craigslist Post | Post']);
        $permission_cr_parse = Permission::create(['name' => 'IT | Craigslist Post | Parse']);

        $roleManager->givePermissionTo([$fullAccess, $permission_cr_post, $permission_cr_parse]);

        //

        $this->call([CraigslistPostTemplateSeeder::class]);

        $readOnly = Permission::create(['name' => 'IT | Craigslist Post Template | ReadOnly']);
        $fullAccess = Permission::create(['name' => 'IT | Craigslist Post Template | FullAccess']);

        //

        $this->call([PostScheduledSeeder::class]);

        $readOnly = Permission::create(['name' => 'IT | Post Scheduled | ReadOnly']);
        $fullAccess = Permission::create(['name' => 'IT | Post Scheduled | FullAccess']);

        //

        $this->call([UserSeeder::class]);
    }
}
