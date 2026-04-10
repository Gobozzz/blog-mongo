<?php

declare(strict_types=1);

namespace App\Repositories\Tag;

use Illuminate\Support\Collection;

interface TagRepositoryContract
{
    public function all(): Collection;
}
