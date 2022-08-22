<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\EmploymentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'id_number' => fake()->numberBetween(100000, 10000000),
            'email' => fake()->unique()->safeEmail(),
            'documentation' => 'documentation.jpeg',
            'department_id' => fake()->randomELement(Department::pluck('id')),
            'employment_status_id' => fake()->randomELement(EmploymentStatus::pluck('id')),
        ];
    }
}
