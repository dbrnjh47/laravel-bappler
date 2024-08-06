<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BankCard>
 */
class BankCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $banks = ['visa', 'master', 'maestro', 'american_express'];
        $statuses = ['active', 'not_active', 'no_funds', 'expired'];

        $card = fake()->creditCardDetails();
        return [
            "first_name" => fake()->firstName(),
            "last_name" => fake()->lastName(),
            "card_number" => $card['number'],
            "expiration" => fake()->creditCardExpirationDateString(),
            "cvc" => rand(100,999),
            "bank" => $card['type'],
            "status" => $statuses[array_rand($statuses, 1)],
            "billing_address" => fake()->address(),
            "lInks_accounts" => null,
        ];
    }
}
