<?php

declare(strict_types=1);

namespace Domain\Product\Collections;

use Domain\Product\Models\OptionValue;
use Illuminate\Database\Eloquent\Collection as BaseCollection;
use Illuminate\Support\Collection;

final class OptionValueCollection extends BaseCollection
{
    public function transformToKeyValuePairs(): Collection|OptionValueCollection
    {
        return $this->mapToGroups(
            fn (OptionValue $value) => [$value->option->title => $value]
        );
    }
}
