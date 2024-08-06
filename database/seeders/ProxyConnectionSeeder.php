<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ProxyConnection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class ProxyConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(env('APP_TEST') == 1)
        {
            $this->filling();
        }
    }

    public function filling()
    {
        $sqlFile = Storage::path('migration/proxiy/proxy_connections.sql');
        $dbName = (new ProxyConnection())->getTable();

        $sql = file_get_contents($sqlFile);
        $sql = str_replace('%DB_NAME%', $dbName, $sql);

        DB::unprepared($sql);
    }
}
