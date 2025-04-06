<?php

namespace BadMushroom\Shorties\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UrlFactory extends Factory
{
    protected $model = \BadMushroom\Shorties\Models\Url::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'long_url'   => $this->faker->url(),
            'short_code' => $this->faker->unique()->word(),
        ];
    }
}
