<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matricule' => 'EMP-' . $this->faker->unique()->numberBetween(1000, 9999),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'job_title' => $this->faker->randomElement(['Médecin', 'Infirmier', 'Comptable', 'Réceptionniste']),
            'department' => $this->faker->randomElement(['Cardiologie', 'RH', 'Urgences', 'Finance']),
            'base_salary' => $this->faker->randomFloat(2, 150000, 800000),
            'hire_date' => $this->faker->date(),
            'status' => 'active',
        ];
    }
}
