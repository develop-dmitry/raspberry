<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Look>
 */
class LookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $minTemperature = $this->faker->numberBetween(-50, 10);
        $maxTemperature = $this->faker->numberBetween($minTemperature + 1, $minTemperature + 10);

        return [
            'name' => $this->faker->text(50),
            'slug' => $this->faker->slug(),
            'photo' => $this->faker->imageUrl(),
            'min_temperature' => $minTemperature,
            'max_temperature' => $maxTemperature
        ];
    }
}
