<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class BaseFilter implements FilterContract
{
    protected function __construct() {}

    protected string $column;

    protected string $requestKey;

    protected string $operator = '=';

    protected mixed $value = null;

    protected array $values = [];

    protected ?string $relation = null;

    /**
     * @var null|callable(Builder, mixed:value): Builder
     */
    protected $customBuilderQuery = null;

    public static function make(string $column, string $requestKey, array $values = []): static
    {
        $instance = new static;
        $instance->column = $column;
        $instance->requestKey = $requestKey;
        $instance->values = $values;

        return $instance;
    }

    public function apply(Builder $builder): Builder
    {
        $this->setValue();

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

    public function setValues(array $values): static
    {
        $this->values = $values;

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

    protected function setValue(): void
    {
        $value = $this->getValue();

        $this->value = $value;
    }

    protected function getValue(): mixed
    {
        return $this->prepareValue($this->values[$this->requestKey] ?? null);
    }

    protected function prepareValue(mixed $value): mixed
    {
        if (is_string($value)) {
            $value = trim($value);
        }

        return $value;
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
