<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
final class PostFactory extends Factory
{
    /**
     * The current slug being used by the factory.
     */
    private static ?string $slug = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => self::$slug = $this->faker->sentence(),
            'slug' => Str::slug(self::$slug),
            'short_description' => $this->faker->paragraph(),
            'content' => $this->faker->paragraphs(3, true),
            'views' => $this->faker->numberBetween(0, 1000),
            'published_at' => $this->faker->dateTime(),
            'tags' => ['laravel', 'php'],
        ];
    }

    /**
     * Indicate that the model's published at should be unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes): array => [
            'published_at' => null,
        ]);
    }
}
