<?php

declare(strict_types=1);

namespace App\Filters\Collections;

use App\Filters\ContainFilter;
use App\Filters\SearchFilter;
use Illuminate\Database\Eloquent\Builder;

class PostCollectionFilters extends BaseCollectionFilters
{
    public function toArray(): array
    {
        return [
            SearchFilter::make(column: 'title', requestKey: 'f_search', values: $this->values)
                ->setCustomBuilderQuery(function (Builder $builder, mixed $value) {
                    return $builder->where(function (Builder $subBuilder) use ($value) {
                        $subBuilder->where('title', 'regex', $value)
                            ->orWhere('content', 'regex', $value);
                    });
                }),
            ContainFilter::make(column: 'slug', requestKey: 'f_tag', values: $this->values)
                ->setRelation('tags'),
        ];
    }
}
