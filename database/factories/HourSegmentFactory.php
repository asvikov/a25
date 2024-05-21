<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HourSegment>
 */
class HourSegmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::query()->inRandomOrder()->first()->value('id'),
            'amount' => $this->faker->numberBetween(1, 8),
            'date' => $this->faker->date()
        ];
    }
}
