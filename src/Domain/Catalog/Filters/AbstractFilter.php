<?php

declare(strict_types=1);

namespace Domain\Catalog\Filters;

use Illuminate\Support\Stringable;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter implements \Stringable
{
    protected const ROOT_KEY = 'filters';

    public function __invoke(Builder $builder, $next)
    {
        return $next($this->apply($builder));
    }

    public function __toString(): string
    {
        return view($this->view(), ['filter' => $this])->render();
    }

    public function filterValueFromRequest(string $nested = null, mixed $default = null): mixed
    {
        $chain = str(static::ROOT_KEY)
            ->append('.' . $this->filterKeyInRequest())
            ->when($nested, fn (Stringable $str) => $str->append(".$nested"));

        return request($chain, $default);
    }

    public function nameAttribute(string $nested = null): string
    {
        return str($this->filterKeyInRequest())
            ->wrap('[', ']')
            ->prepend(static::ROOT_KEY)
            ->when($nested, fn (Stringable $str) => $str->append("[$nested]"))
            ->value();
    }

    public function idAttribute(string $nested = null): string
    {
        return str($this->nameAttribute($nested))->slug();
    }

    abstract public function apply(Builder $query): Builder;

    abstract public function view(): string;

    abstract public function viewTitle(): string;

    abstract public function viewValues(): array;

    abstract public function filterKeyInRequest(): string;
}
