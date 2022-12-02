<?php

declare(strict_types=1);

namespace Domain\Product\Collections;

use Illuminate\Database\Eloquent\Collection as BaseCollection;
use Illuminate\Support\Collection;

final class PropertyCollection extends BaseCollection
{
    public function transformToKeyValuePairs(): Collection|PropertyCollection
    {
        return $this->mapWithKeys(
            fn ($property) => [$property->title => $property->pivot->value]
        );
    }
}
