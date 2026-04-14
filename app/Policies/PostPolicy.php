<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function toModeration(User $user, Post $post): bool
    {
        return $user->getKey() === $post->user_id;
    }

    public function toPublished(User $user, Post $post): bool
    {
        return $user->role === UserRole::MODERATOR;
    }

    public function toDraft(User $user, Post $post): bool
    {
        return $user->getKey() === $post->user_id;
    }

    public function toModerationFromPublished(User $user, Post $post): bool
    {
        return $user->role === UserRole::MODERATOR;
    }
}
