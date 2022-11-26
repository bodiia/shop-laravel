<?php

declare(strict_types=1);

namespace Support\ViewModels;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
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
            ->reject(fn (ReflectionMethod $method) => $this->shouldIgnore($method))
            ->mapWithKeys(function (ReflectionMethod $method) {
                return [$this->formattingKey($method) => $this->createVariableFromMethod($method)];
            });

        return $methods->all();
    }

    private function formattingKey(ReflectionMethod $method): string
    {
        return str($method->getName())->snake()->value();
    }

    private function shouldIgnore(ReflectionMethod $method): bool
    {
        return str($method->getName())->startsWith('__') || in_array($method->getName(), static::IGNORED_METHODS);
    }

    private function createVariableFromMethod(ReflectionMethod $method): mixed
    {
        if ($method->getNumberOfParameters() == 0) {
            return $this->{ $method->getName() }();
        }

        return Closure::fromCallable([$this, $method->getName()]);
    }
}
