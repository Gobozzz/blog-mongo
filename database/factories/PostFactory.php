<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(rand(3, 8)),
            'content' => fake()->realTextBetween(500, 1000),
            'user_id' => User::randomId() ?? User::factory(),
            'created_at' => fake()->dateTime(),
            'status' => 'draft',
        ];
    }

    public function withTags(?int $count = 1): static
    {
        return $this->afterCreating(function (Post $post) use ($count) {
            $existingTagIds = Tag::randomIds($count) ?? [];

            $missingCount = $count - count($existingTagIds);
            if ($missingCount > 0) {
                $newTags = Tag::factory($missingCount)->create();
                $newTagIds = $newTags->pluck('_id')->toArray();
                $tagIds = array_merge($existingTagIds, $newTagIds);
            } else {
                $tagIds = $existingTagIds;
            }

            if (! empty($tagIds)) {
                $post->tags()->attach($tagIds);
            }
        });
    }

    public function withComments(?int $count = 1): static
    {
        return $this->afterCreating(function (Post $post) use ($count) {
            Comment::factory($count)->create([
                'post_id' => $post->getKey(),
            ]);
        });
    }
}
