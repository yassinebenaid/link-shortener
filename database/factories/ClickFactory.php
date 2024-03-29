<?php

namespace Database\Factories;

use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Click>
 */
class ClickFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model_type' => Link::class,
            'platform' => ['linux', 'windows', 'macos', 'android'][rand(0, 3)],
            'device' => ['mobile', 'robot', 'desktop', 'tablet'][rand(0, 3)],
            'created_at' => now()->subDays(rand(0, 30)),
            'updated_at' => now()->subDays(rand(0, 30)),
        ];
    }
}
