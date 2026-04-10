<?php

declare(strict_types=1);

namespace App\Repositories\Post;

use App\Filters\Collections\PostCollectionFilters;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostEloquentRepository implements PostRepositoryContract
{
    public function paginate(int $perPage = 8): LengthAwarePaginator
    {
        $query = Post::query()
            ->with(['user', 'tags'])
            ->filters(PostCollectionFilters::class)
            ->latest()
            ->paginate(8);

        return $query;
    }
}
