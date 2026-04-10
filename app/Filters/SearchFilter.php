<?php

declare(strict_types=1);

namespace App\Filters;

use MongoDB\BSON\Regex;

class SearchFilter extends BaseFilter
{
    protected string $operator = 'regex';

    protected ?string $pattern = null;

    protected string $flags = 'i';

    public function setValue(mixed $customValue = null): static
    {
        if (is_string($customValue)) {
            $this->value = $this->getRegexByString($customValue);

            return $this;
        }

        $value = $this->getRequestValue();

        if (is_string($value)) {
            $this->value = $this->getRegexByString($value);
        }

        return $this;
    }

    /**
     * @param  $callBackPattern  callable(mixed $value): string
     */
    public function setPattern(callable $callBackPattern): static
    {
        $this->pattern = ($callBackPattern)($this->value);

        return $this;
    }

    public function setFlags(string $flags): static
    {
        $this->flags = $flags;

        return $this;
    }

    public function caseSensitive(): static
    {
        if (str_contains($this->flags, 'i')) {
            $this->flags = str_replace('i', '', $this->flags);
        }

        return $this;
    }

    protected function getRegexByString(string $value): Regex
    {
        return new Regex($this->pattern ?? $value, $this->flags);
    }
}
