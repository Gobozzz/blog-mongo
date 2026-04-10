<?php

declare(strict_types=1);

namespace App\Traits;

/**
 * Удобно использовать в фабриках. Так как метод inRandomOrder() не поддердживается в MongoDB.
 * Это удобная замена для использования в фабриках. Пример:
 * public function definition(): array
 *      {
 *          return [
 *              'title' => fake()->sentence(rand(3, 8)),
 *              'content' => fake()->realTextBetween(500, 1000),
 *              'user_id' => User::randomId() ?? User::factory(),
 *         ];
 *      }
 */
trait HasRandomFetchModel
{
    public static function randomId(): ?string
    {
        $result = static::raw(fn ($c) => $c->aggregate([
            ['$sample' => ['size' => 1]],
        ])->toArray())[0] ?? null;

        return $result ? (string) $result['_id'] : null;
    }

    public static function randomIds(int $count = 1): ?array
    {
        $results = static::raw(fn ($c) => $c->aggregate([
            ['$sample' => ['size' => $count]],
        ])->toArray());

        if (empty($results)) {
            return null;
        }

        return array_map('strval', array_column($results, '_id'));
    }
}
