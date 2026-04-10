<?php

namespace App\Repositories\Tag;

use App\Models\Tag;
use Illuminate\Support\Collection;

class TagEloquentRepository implements TagRepositoryContract
{
    public function all(): Collection
    {
        return Tag::all();
    }
}
