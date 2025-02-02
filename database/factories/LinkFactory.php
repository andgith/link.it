<?php

namespace Database\Factories;

use App\Models\Domain;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => $key = fake()->uuid(),
            'domain_id' => Domain::factory(),
            'url' => fake()->url(),
            'link' => function (array $attributes) {
                $domain = Domain::find($attributes['domain_id']);
                return "https://{$domain->domain}/{$attributes['key']}";
            },
            'clicks' => 0,
            'password' => null,
            'expires_at' => null,
            'last_clicked_at' => null,
        ];
    }
}
