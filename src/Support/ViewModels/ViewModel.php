<?php

declare(strict_types=1);

namespace Support\ViewModels;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

abstract class ViewModel implements Arrayable
{
    protected const IGNORED_METHODS = [
        'toArray'
    ];

    public function toArray(): array
    {
        $class = new ReflectionClass($this);

        $methods = collect($class->getMethods(ReflectionMethod::IS_PUBLIC))
            ->reject(function (ReflectionMethod $method) {
                return str($method->getName())->startsWith('__')
                    || in_array($method->getName(), static::IGNORED_METHODS);
            })
            ->mapWithKeys(function (ReflectionMethod $method) {
                return [str($method->getName())->snake()->value() => $this->createVariableFromMethod($method)];
            });

        return $methods->toArray();
    }

    protected function createVariableFromMethod(ReflectionMethod $method): mixed
    {
        if ($method->getNumberOfParameters() == 0) {
            return $this->{ $method->getName() }();
        }

        return Closure::fromCallable([$this, $method->getName()]);
    }
}
