<?php

declare(strict_types=1);

namespace App\Traits;

use App\Filters\Collections\CollectionFiltersContract;
use App\Filters\FilterContract;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

trait HasFilters
{
    /**
     * @param  FilterContract[]|string  $filters
     */
    #[Scope]
    public function filters(Builder $query, array|string $filters): Builder
    {
        $filters = $this->parseFilters($filters);

        foreach ($filters as $filter) {
            if ($filter instanceof FilterContract) {
                $query = $filter->apply($query);
            }
        }

        return $query;
    }

    private function parseFilters(array|string $filters): array
    {
        if (is_array($filters)) {
            return $filters;
        }

        if (is_string($filters)) {
            $filters = app($filters);
        }

        if ($filters instanceof CollectionFiltersContract) {
            return $filters->toArray();
        }

        throw new \InvalidArgumentException(
            'Filters must be an array, a class string implementing CollectionFiltersContract'
        );
    }
}
