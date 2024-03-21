<?php
// database/factories/OfferFactory.php

namespace Database\Factories;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'discount' => $this->faker->numberBetween(5, 50), // Random discount between 5% to 50%
            'start_date' => Carbon::now()->subDays(10)->format('Y-m-d'), // Start date 10 days ago
            'end_date' => Carbon::now()->addDays(10)->format('Y-m-d'), // End date 10 days from now
            'active' => true,
        ];
    }
}