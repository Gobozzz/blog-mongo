<?php

declare(strict_types=1);

namespace App\Filters\Collections;

abstract class BaseCollectionFilters implements CollectionFiltersContract
{
    protected array $values = [];

    protected function __construct() {}

    public static function make(array $values): static
    {
        $instance = new static;
        $instance->values = $values;

        return $instance;
    }

    public function toArray(): array
    {
        return [];
    }
}
