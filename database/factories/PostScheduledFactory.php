<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostScheduled>
 */
class PostScheduledFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_at = fake()->unique()->dateTimeBetween(Carbon::now()->addDay(), Carbon::now()->addMonth());
        $end_at = Carbon::parse($start_at);
        $days = rand(0, 5);
        if ($days > 0) {
            $end_at->addDays($days);
        }

        $hours = rand(1,3);
        $randomTime = Carbon::now()->addSeconds(random_int(0, 86400));
        $endTime = $randomTime->copy()->addHours($hours);
        if ($endTime->diffInDays($randomTime) >= 1) {
            $randomTime->subHours($hours);
        }

        $schedule_types = ['random', 'days', 'time'];

        return [
            // 'scheduled_start_date' => $start_at,
            // 'scheduled_end_date' => $end_at,
            // 'start_time' => $randomTime,
            // 'end_time' => $endTime,
            // 'posts_quantity' => rand(1, 10),
            // 'schedule_type' => $schedule_types[array_rand($schedule_types, 1)]
        ];
    }
}
