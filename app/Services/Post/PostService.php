<?php

declare(strict_types=1);

namespace App\Services\Post;

use App\DTO\Post\PostCreateDTO;
use App\Events\Post\PostCreatedEvent;
use App\Models\Post;
use App\Repositories\Post\PostRepositoryContract;

class PostService implements PostServiceContract
{
    public function __construct(
        private readonly PostRepositoryContract $postRepository,
    ) {}

    public function create(PostCreateDTO $data): Post
    {
        $post = $this->postRepository->create($data);

        event(new PostCreatedEvent($post->getKey()));

        return $post;
    }
}
