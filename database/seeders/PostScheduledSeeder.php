<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PostScheduled;
use App\Models\CraigslistPost;
use App\Models\CraigslistPostTask;
use App\Models\CraigslistPostTemplate;
use Carbon\Carbon;

class PostScheduledSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (env('APP_TEST') == 1) {
            $this->craigslistPosts();
        }
    }

    public function craigslistPosts()
    {
        $craigslistPosts = CraigslistPostTemplate::limit(10)->get();
        $model_type = get_class(new CraigslistPostTemplate());

        foreach ($craigslistPosts as $craigslistPost) {
            $this->create($model_type, $craigslistPost->id);
        }

        return;
    }

    public $schedule_types = ['random', 'days', 'time'];

    public function create($model_type, $model_id)
    {
        $start_at = fake()->unique()->dateTimeBetween(Carbon::now()->addDay(), Carbon::now()->addMonth());
        $end_at = Carbon::parse($start_at);
        $days = rand(-5, 5);
        if($days > 0){$end_at->addDays($days);}

        //

        $hours = rand(1,3);
        $randomTime = Carbon::now()->addSeconds(random_int(0, 86400));
        $endTime = $randomTime->copy()->addHours($hours);
        if ($endTime->diffInDays($randomTime) >= 1) {
            $randomTime->subHours($hours);
        }

        // for($i = 0; $i <= $days; $i++)
        // {
        //     $end_at->addDay();

        //     $task_id = null;
        //     $task_type = null;
        //     switch($model_type){
        //         case "App\Models\CraigslistPostTemplate":
        //             $task = CraigslistPostTask::factory()->create([
        //                 'scheduled_start_date' => $end_at,
        //                 'scheduled_end_date' => $end_at,
        //                 'start_time' => $randomTime,
        //                 'end_time' => $endTime,

        //                 'posts_quantity' => rand(1, 10),
        //                 'schedule_type' => $this->schedule_types[array_rand($this->schedule_types, 1)]
        //             ]);
        //             $task_id = $task->id;
        //             $task_type = get_class(new CraigslistPostTask());

        //             break;
        //     }
        // }

        PostScheduled::factory()->create([
            'post_type' => $model_type,
            'post_id' => $model_id,

            'scheduled_start_date' => $start_at,
            'scheduled_end_date' => $end_at,
            'start_time' => $randomTime,
            'end_time' => $endTime,
            'posts_quantity' => rand(1, 10),
            'schedule_type' => $this->schedule_types[array_rand($this->schedule_types, 1)]
        ]);
    }
}
