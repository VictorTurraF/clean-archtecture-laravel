<?php

namespace Database\Factories;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seller_id' => Seller::factory(),
            'price_in_cents' => $this->faker->numberBetween(100, 100000), // Example price range
            'payment_approved_at' => $this->faker->dateTime('-1 week'), // 70% chance of having a payment_approved_at date
        ];
    }
}
