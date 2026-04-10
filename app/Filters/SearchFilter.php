<?php

declare(strict_types=1);

namespace App\Filters;

use MongoDB\BSON\Regex;

class SearchFilter extends BaseFilter
{
    protected string $operator = 'regex';

    /**
     * @var null|callable(mixed:value): string
     */
    protected $customPattern = null;

    protected string $flags = 'i';

    /**
     * @param  $callBackPattern  callable(mixed $value): string
     */
    public function setCustomPattern(callable $callBackPattern): static
    {
        $this->customPattern = $callBackPattern;

        return $this;
    }

    public function startsWith(): static
    {
        $this->customPattern = fn (mixed $value) => '^'.$value;

        return $this;
    }

    public function endsWith(): static
    {
        $this->customPattern = fn (mixed $value) => $value.'$';

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

    protected function setValue(): void
    {
        $value = $this->getValue();

        if (is_string($value)) {
            $this->value = $this->getRegexByString($value);
        }
    }

    protected function shouldSkipFilter(): bool
    {
        return ! ($this->value instanceof Regex) || empty(trim($this->value->getPattern()));
    }

    protected function getRegexByString(string $string): Regex
    {
        $pattern = $this->customPattern ? ($this->customPattern)($string) : $string;

        return new Regex($pattern, $this->flags);
    }
}
