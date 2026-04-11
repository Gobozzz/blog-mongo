<?php

declare(strict_types=1);

namespace App\Repositories\Post;

use App\DTO\Post\PostCreateDTO;
use App\Filters\Collections\PostCollectionFilters;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostEloquentRepository implements PostRepositoryContract
{
    public function paginate(int $perPage = 8, array $filtersData = []): LengthAwarePaginator
    {
        return Post::query()
            ->with(['user', 'tags'])
            ->filters(PostCollectionFilters::make($filtersData))
            ->latest()
            ->paginate($perPage);
    }

    public function create(PostCreateDTO $data): Post
    {
        $post = Post::query()->create([
            'title' => $data->title,
            'content' => $data->content,
            'user_id' => $data->userId,
        ]);

        if (! empty($data->tagsIds)) {
            $post->tags()->attach($data->tagsIds);
        }

        return $post;
    }

    public function getByUser(mixed $userId, int $perPage = 8, array $filtersData = []): LengthAwarePaginator
    {
        return Post::query()
            ->where('user_id', $userId)
            ->with(['user', 'tags'])
            ->filters(PostCollectionFilters::make($filtersData))
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(mixed $id): Post
    {
        return Post::query()->findOrFail($id);
    }
}
