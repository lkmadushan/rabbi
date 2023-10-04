<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'topic' => fake()->randomElement([
                'Topic 1',
                'Topic 2',
                'Topic 3',
            ]),
            'content' => fake()->text()
        ];
    }
}
