<?php

declare(strict_types=1);

namespace App\Repositories\Post;

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
}
