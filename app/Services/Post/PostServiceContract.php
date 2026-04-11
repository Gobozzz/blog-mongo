<?php

declare(strict_types=1);

namespace App\Services\Post;

use App\DTO\Post\PostCreateDTO;
use App\Models\Post;

interface PostServiceContract
{
    public function create(PostCreateDTO $data): Post;
}
