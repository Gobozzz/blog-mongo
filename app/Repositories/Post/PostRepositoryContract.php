<?php

declare(strict_types=1);

namespace App\Repositories\Post;

use App\DTO\Post\PostCreateDTO;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface PostRepositoryContract
{
    public function paginate(int $perPage = 8, array $filtersData = []): LengthAwarePaginator;

    public function create(PostCreateDTO $data): Post;

    public function getByUser(mixed $userId, int $perPage = 8, array $filtersData = []): LengthAwarePaginator;

    /**
     * @throws ModelNotFoundException
     */
    public function findOrFail(mixed $id): Post;
}
