<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BankCard;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CraigslistPostTemplate>
 */
class CraigslistPostTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['scheduled', 'not_active'];

        $start_at = fake()->unique()->dateTimeBetween(Carbon::now()->addDay(), Carbon::now()->addMonth());
        $end_at = Carbon::parse($start_at);
        $days = rand(0, 5);
        if($days > 0){
            $end_at->addDays($days);
        }

        return [
            "posting_start_at" => $start_at,
            "posting_end_at" => $end_at,
            "status" => $statuses[array_rand($statuses, 1)],
            "bank_card_id" => BankCard::inRandomOrder()->first()->id,
        ];
    }
}
