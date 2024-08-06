<?php

namespace App\Http\Services\Craigslist;

use App\Models\CraigslistPost;
use App\Http\Services\Craigslist\API\CraigslistApi;
use App\Http\Services\PostScheduled\PostScheduledServices;
use Carbon\Carbon;
use App\Http\Services\SaveFileServices;
use App\Models\CraigslistPostTemplate;

class CraigslistServices
{
    public function find($id)
    {
        return CraigslistPost::findOrFail($id);
    }
    public function post($post_id)
    {
        $post = $this->find($post_id);
        (new CraigslistApi($post->browser_profile->uuid))->post($post->uuid);
        $post->last_posted_at = now();
        $post->save();

        return;
    }
    public function parse($browser_profile)
    {
        $posts = (new CraigslistApi($browser_profile->uuid))->getPosts();

        if(!$posts){throw new \Exception("Error");}
        foreach ($posts as $post) {
            $where_data = ["uuid" => $post["id"], "browser_profile_id" => $browser_profile->id];

            $data = $post;
            $data["last_posted_at"] = Carbon::parse($data["last_posted_at"]);

            //

            unset($data["id"], $data["image_bytes"]);
            $p = $this->updatedOrCreatePost($where_data, $data);

            //

            // удаляем картинку если есть
            if($p->preview)
            {
                (new SaveFileServices)->distroy(CraigslistPost::PATH, str_replace(CraigslistPost::PATH, "", $p->preview));
            }

            // сохранение картинки
            $imgName = (new SaveFileServices)->convertBytes($post["image_bytes"]);
            $imgName = (new SaveFileServices)->saveOne($imgName, CraigslistPost::PATH, false, is_bytes:true);
            // $imgName = (new SaveFileServices)->resize(CraigslistPost::PATH, $imgName, 685, null, "webp");

            $p->preview = $imgName;
            $p->save();
        }

        return;
    }
    public function updatedOrCreatePost($where_data, $data)
    {
        return CraigslistPost::updateOrCreate(
            $where_data,
            $data
        );
    }

    public function createAPI($post_id)
    {
        $postScheduled = (new PostScheduledServices)->find($post_id);
        $data = $postScheduled->post->toArray();
        unset($data["id"], $data["posting_start_at"], $data["posting_end_at"], $data["status"], $data["bank_card_id"], $data["created_at"], $data["updated_at"]);
        // $record = $this->updatedOrCreatePost([], $data);

        $record = CraigslistPost::first();
        // dd($record->description);
        $id_post = (new CraigslistApi($record->browser_profile->uuid))->create([
            "image_bytes" => [1],
            "title" => $record->title,
            "city" => $record->city,
            "zip" => $record->zip,
            "description" => $record->description,

            "show_phone" => ($record->show_phone ? 'true' : 'false'),
            "phone_calld" => ($record->phone_calld ? 'true' : 'false'),
            "text_ok" => ($record->text_ok ? 'true' : 'false'),

            "phone_number" => $record->phone_number,
            "name" => $record->name,
            "extension" => $record->extension,
            "email_privacy" => $record->email_privacy,
        ]);
        dd($id_post);
    }
}
