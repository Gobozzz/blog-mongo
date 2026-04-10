<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ContainFilter extends BaseFilter
{
    private const IN_OPERATOR = 'IN';

    private const NOT_IN_OPERATOR = 'NOT IN';

    protected string $operator = self::IN_OPERATOR;

    public function notInMode(): static
    {
        $this->operator = self::NOT_IN_OPERATOR;

        return $this;
    }

    protected function shouldSkipFilter(): bool
    {
        return ! is_array($this->value) || empty($this->value);
    }

    protected function buildQuery(Builder $builder): Builder
    {
        if ($this->customBuilderQuery !== null) {
            return ($this->customBuilderQuery)($builder, $this->value);
        }

        if ($this->relation !== null) {
            return $builder->whereHas($this->relation, function (Builder $subQuery) {
                $this->applyFilterByOperator($subQuery);
            });
        }

        return $this->applyFilterByOperator($builder);
    }

    protected function applyFilterByOperator(Builder $builder): Builder
    {
        return match ($this->operator) {
            self::NOT_IN_OPERATOR => $builder->whereNotIn($this->column, $this->value),
            self::IN_OPERATOR => $builder->whereIn($this->column, $this->value),
            default => throw new \InvalidArgumentException("Invalid operator: {$this->operator}"),
        };
    }
}
