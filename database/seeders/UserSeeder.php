<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $this->angelina_proshina();
    }

    public function angelina_proshina()
    {
        $user = User::firstOrCreate(
            ['email' => 'angelina_proshina@bappler.com'],
            [
                'name' => 'Ангелина Прошина',
                'password' => Hash::make('gBx8yV'),
            ]
        );

        $permission_cr_post = Permission::where(['name' => 'IT | Craigslist Post | Post'])->first();
        $permission_cr_parse = Permission::where(['name' => 'IT | Craigslist Post | Parse'])->first();

        $permission_cr_readOnly = Permission::where(['name' => 'IT | Craigslist Post | ReadOnly'])->first();
        $permission_bp_readOnly = Permission::where(['name' => 'IT | Browser Profile | ReadOnly'])->first();

        $user->givePermissionTo([$permission_cr_post, $permission_cr_parse, $permission_cr_readOnly, $permission_bp_readOnly]);
    }
}
