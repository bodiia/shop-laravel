<?php

declare(strict_types=1);

namespace Domain\Catalog\Filters;

final class FilterManager
{
    /**
     * @param array<AbstractFilter> $filters
     */
    public function __construct(
        protected array $filters = []
    ) {
    }

    public function registerFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }
}
