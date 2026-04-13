<?php

namespace App\Models;

use App\Traits\HasFilters;
use App\Traits\HasRandomFetchModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\BelongsToMany;
use MongoDB\Laravel\Relations\HasMany;
use Sebdesign\SM\Facade as StateMachine;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, HasFilters, HasRandomFetchModel;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'status',
    ];

    public function getCurrentStateLabel(): string
    {
        $stateMachine = StateMachine::get($this, 'posts_state_machine');

        return match ($stateMachine->getState()) {
            'draft' => 'Черновик',
            'moderation' => 'На модерации',
            'published' => 'Опубликована',
            default => 'Неизвестно'
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
