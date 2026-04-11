<?php

declare(strict_types=1);

namespace App\DTO\Post;

final readonly class PostCreateDTO
{
    public function __construct(
        public string $title,
        public string $content,
        public mixed $userId,
        public array $tagsIds = [],
    ) {}
}
