<?php

declare(strict_types=1);

namespace App\Listeners\Post;

use App\Events\Post\PostCreatedEvent;
use App\Repositories\Post\PostRepositoryContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class PostCreatedLogging implements ShouldQueue
{
    public function __construct(
        private readonly PostRepositoryContract $postRepository,
    ) {
        //
    }

    public function handle(PostCreatedEvent $event): void
    {
        $post = $this->postRepository->findOrFail($event->postId);

        Log::info('Post created', [
            'id' => $post->getKey(),
            'title' => $post->title,
            'datetime' => $post->created_at,
        ]);
    }
}
