<?php

declare(strict_types=1);

namespace App\Filters\Collections;

use App\Filters\FilterContract;

interface CollectionFiltersContract
{
    /**
     * @return FilterContract[]
     */
    public function toArray(): array;
}
