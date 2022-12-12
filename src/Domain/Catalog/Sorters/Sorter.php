<?php

declare(strict_types=1);

namespace Domain\Catalog\Sorters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

final class Sorter
{
    private const SORT_KEY = 'sort';

    public function __construct(private readonly array $columns = [])
    {
    }

    public function execute(Builder $query): Builder
    {
        $value = $this->getSortValueFromRequest();

        return $query->when($value->contains($this->columns), function (Builder $q) use ($value) {
            $q->orderBy($this->getColumnForSorting($value), $this->getDirection($value));
        });
    }

    public function getSortValueFromRequest(): Stringable
    {
        return Str::of(Request::input(self::SORT_KEY));
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
