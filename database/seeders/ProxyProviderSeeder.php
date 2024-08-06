<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ProxyProvider;

class ProxyProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        if(env('APP_TEST') == 1)
        {
            ProxyProvider::factory(1)->create([
                'email' => 'rinat.bermileev@gmail.com',
                'login' => 'RINAT BERMILEEV',
                'name' => 'proxy_cheap',
                'api_key' => '72c6bd98-05a2-4f1b-9eaf-7d34ba3409a6',
                'secret_key' => 'bfa0ce55-87f5-4fa6-a388-c4cffcf6f0a5',
            ]);
        }
    }
}
