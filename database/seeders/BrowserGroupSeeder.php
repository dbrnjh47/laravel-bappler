<?php

namespace Database\Seeders;

use App\Models\BrowserGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class BrowserGroupSeeder extends Seeder
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
        $sqlFile = Storage::path('migration/browser/browser_groups.sql');
        $dbName = (new BrowserGroup())->getTable();

        $sql = file_get_contents($sqlFile);
        $sql = str_replace('%DB_NAME%', $dbName, $sql);

        DB::unprepared($sql);
    }
}
