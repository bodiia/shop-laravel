<?php

declare(strict_types=1);

namespace Domain\Catalog\Sorters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Stringable;

final class Sorter
{
    private const SORT_KEY = 'sort';

    public function __construct(private readonly array $columns = [])
    {
    }

    public function execute(Builder $query): void
    {
        $value = $this->getSortValueFromRequest();

        $query->when(
            $value->contains($this->columns),
            fn (Builder $q) => $q->orderBy(
                $this->getColumnForSorting($value),
                $this->getDirection($value)
            )
        );
    }

    public function getSortValueFromRequest(): Stringable
    {
        return str(request(self::SORT_KEY));
    }

    public function getDirection(Stringable $value): string
    {
        return $value->contains('-') ? 'DESC' : 'ASC';
    }

    public function getColumnForSorting(Stringable $value): string
    {
        return $value->remove('-')->value();
    }
}
