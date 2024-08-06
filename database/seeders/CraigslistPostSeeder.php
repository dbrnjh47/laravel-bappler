<?php

namespace Database\Seeders;

use App\Models\CraigslistPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class CraigslistPostSeeder extends Seeder
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
        $sqlFile = Storage::path('migration/craigslist/craigslist_posts.sql');
        $dbName = (new CraigslistPost())->getTable();

        $sql = file_get_contents($sqlFile);
        $sql = str_replace('%DB_NAME%', $dbName, $sql);

        DB::unprepared($sql);
    }
}
