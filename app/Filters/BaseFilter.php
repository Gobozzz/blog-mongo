<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class BaseFilter implements FilterContract
{
    protected function __construct()
    {
    }

    protected string $column;

    protected string $requestKey;

    protected string $operator = '=';

    protected mixed $value = null;

    protected ?string $relation = null;

    /**
     * @var null|callable(Builder, mixed:value): Builder
     */
    protected $customBuilderQuery = null;

    public static function make(string $column, string $requestKey): static
    {
        $instance = new static;
        $instance->column = $column;
        $instance->requestKey = $requestKey;

        return $instance;
    }

    public function apply(Builder $builder): Builder
    {
        if ($this->value === null) {
            $this->setValue();
        }

        if ($this->shouldSkipFilter()) {
            return $builder;
        }

        return $this->buildQuery($builder);
    }

    public function setOperator(string $operator): static
    {
        $this->operator = $operator;

        return $this;
    }

    public function setRelation(string $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * @param  $callback  callable(Builder): Builder
     */
    public function setCustomBuilderQuery(callable $callback): static
    {
        $this->customBuilderQuery = $callback;

        return $this;
    }

    public function setValue(mixed $customValue = null): static
    {
        if ($customValue !== null) {
            $this->value = $customValue;

            return $this;
        }

        $value = $this->getRequestValue();

        $this->value = $value;

        return $this;
    }

    protected function getRequestValue(): mixed
    {
        return request()->input($this->requestKey);
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
        return $builder->where($this->column, $this->operator, $this->value);
    }

    protected function shouldSkipFilter(): bool
    {
        return $this->value === null || $this->value === '';
    }
}
