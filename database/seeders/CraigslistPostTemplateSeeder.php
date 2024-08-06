<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\CraigslistPost;
use App\Models\CraigslistPostTemplate;

class CraigslistPostTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $craigslistPosts = CraigslistPost::get();

        foreach($craigslistPosts as $craigslistPost)
        {
            CraigslistPostTemplate::factory(1)->create([
                "title" => $craigslistPost->title,
                "preview" => str_replace(CraigslistPost::PATH, "", $craigslistPost->preview),
                "city" => $craigslistPost->city,
                "zip" => $craigslistPost->zip,
                "description" => $craigslistPost->description,
                "email_privacy" => $craigslistPost->email_privacy,
                "show_phone" => $craigslistPost->show_phone,
                "phone_calld" => $craigslistPost->phone_calld,
                "text_ok" => $craigslistPost->text_ok,
                "phone_number" => $craigslistPost->phone_number,
                "name" => $craigslistPost->name,
                "extension" => $craigslistPost->extension,
                "browser_profile_id" => $craigslistPost->browser_profile_id
            ]);
        }

    }
}
