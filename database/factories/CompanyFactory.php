<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    public function definition(): array
    {
        $companyName = ucwords($this->faker->unique()->randomElement([
            $this->faker->colorName(),
            $this->faker->word,
        ]).' '.$this->faker->word());

        return [
            'name' => $companyName,
            'slug' => Str::kebab(strtolower($companyName)),
            'email' => $this->faker->companyEmail(),
            'mobile' => $this->faker->e164PhoneNumber(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }
}
