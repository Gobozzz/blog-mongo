<?php

declare(strict_types=1);

namespace App\Events\Post;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostCreatedEvent implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public mixed $postId,
    ) {}

}
