<?php

namespace App\Models;

use App\Http\Services\Craigslist\CraigslistPostTaskServices;
use App\Http\Services\PostScheduled\PostScheduledServices;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PostScheduled extends Model
{
    use HasFactory;

    public $table = 'post_scheduled';

    protected $guarded = false;

    public function post(): MorphTo
    {
        return $this->morphTo();
    }

    public function task(): MorphTo
    {
        return $this->morphTo();
    }

    public function craigslistPostTemplate()
    {
        return $this->hasOne(CraigslistPostTemplate::class, 'post_id', 'id');
    }

    public function craigslistPostTask()
    {
        return $this->hasOne(CraigslistPostTask::class, 'task_id', 'id');
    }

    protected static function booted()
    {
        static::creating(function (PostScheduled $post) {
            $data = $post->attributes;
            if ($post->scheduled_start_date != $post->scheduled_end_date) {
                (new PostScheduledServices)->create($data);
            }

            unset($data["task_id"], $data["task_type"], $data["post_type"], $data["post_id"]);
            $data["scheduled_end_date"] = $data["scheduled_start_date"];

            if (!$post->task) {
                $task = null;
                switch ($post->post_type) {
                    case "App\Models\CraigslistPostTemplate":
                        $task = (new CraigslistPostTaskServices)->create($data);
                        break;
                }

                $post->task_id = $task->id;
                $post->task_type = get_class($task);
            }

            //
            $post->scheduled_end_date = $post->scheduled_start_date;
            // unset(
            //     $post->scheduled_end_date,
            //     $post->scheduled_start_date,
            //     $post->start_time,
            //     $post->end_time,
            //     $post->posts_quantity,
            //     $post->schedule_type,
            // );
        });

        static::updated(function (PostScheduled $post) {
            $data = $post->attributes;

            unset($data["id"], $data["task_id"], $data["task_type"]);

            if ($post->task) {
                $post->task()->delete();
            }

            $post->delete();

            (new PostScheduledServices)->create($data, 0);
            // $post->update($post->attributes);
        });

        static::deleted(function (PostScheduled $post) {
            $post->task()->delete();
        });
    }
}
