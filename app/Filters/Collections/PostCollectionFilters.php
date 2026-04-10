<?php

declare(strict_types=1);

namespace App\Filters\Collections;

use App\Filters\ContainFilter;
use App\Filters\SearchFilter;
use Illuminate\Database\Eloquent\Builder;

class PostCollectionFilters implements CollectionFiltersContract
{
    public function toArray(): array
    {
        return [
            SearchFilter::make('title', 'f_search')
                ->setCustomBuilderQuery(function (Builder $builder, mixed $value) {
                    return $builder->where(function (Builder $subBuilder) use ($value) {
                        $subBuilder->where('title', 'regex', $value)
                            ->orWhere('content', 'regex', $value);
                    });
                })->endsWith(),
            ContainFilter::make('slug', 'f_tag')
                ->setRelation('tags'),
        ];
    }
}
