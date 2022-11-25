<?php

declare(strict_types=1);

namespace Domain\Catalog\Filters;

use Illuminate\Database\Eloquent\Builder;
use Stringable;

abstract class AbstractFilter implements Stringable
{
    protected const ROOT_KEY = 'filters';

    public function __invoke(Builder $builder, $next)
    {
        $this->apply($builder);

        $next($builder);
    }

    public function __toString(): string
    {
        return view($this->view(), ['filter' => $this])->render();
    }

    public function filterValueFromRequest(string $nestedKey = null, mixed $default = null): mixed
    {
        $chain = implode('.', [static::ROOT_KEY, $this->filterKeyInRequest()]);

        if (! is_null($nestedKey)) {
            $chain .= ".$nestedKey";
        }

        return request($chain, $default);
    }

    public function nameAttribute(string $nestedKey = null): string
    {
        return str($this->filterKeyInRequest())
            ->wrap('[', ']')
            ->prepend(static::ROOT_KEY)
            ->when($nestedKey, fn (Stringable $str) => $str->append("[$nestedKey]"))
            ->value();
    }

    public function idAttribute(string $nestedKey = null): string
    {
        return str($this->nameAttribute($nestedKey))
            ->slug()
            ->value();
    }

    abstract public function apply(Builder $query): Builder;

    abstract public function view(): string;

    abstract public function viewTitle(): string;

    abstract public function viewValues(): array;

    abstract public function filterKeyInRequest(): string;
}
