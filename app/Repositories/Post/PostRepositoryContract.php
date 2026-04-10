<?php

declare(strict_types=1);

namespace App\Repositories\Post;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostRepositoryContract
{
    public function paginate(int $perPage = 8, array $filtersData = []): LengthAwarePaginator;
}
