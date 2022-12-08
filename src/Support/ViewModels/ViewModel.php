<?php

declare(strict_types=1);

namespace Support\ViewModels;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

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

        $properties = collect($class->getProperties(ReflectionProperty::IS_PUBLIC))
            ->mapWithKeys(function (ReflectionProperty $property) {
                return [$this->formattingKey($property) => $this->{ $property->getName() }];
            });

        return $methods->merge($properties)->all();
    }

    private function formattingKey(ReflectionMethod|ReflectionProperty $field): string
    {
        return Str::snake($field->getName());
    }

    private function shouldIgnore(ReflectionMethod $method): bool
    {
        return Str::startsWith($method->getName(), '__') || in_array($method->getName(), static::IGNORED_METHODS);
    }

    private function createVariableFromMethod(ReflectionMethod $method): mixed
    {
        if ($method->getNumberOfParameters() == 0) {
            return $this->{ $method->getName() }();
        }

        return Closure::fromCallable([$this, $method->getName()]);
    }
}
