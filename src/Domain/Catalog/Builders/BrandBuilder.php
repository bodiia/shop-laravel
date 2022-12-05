<?php

declare(strict_types=1);

namespace Domain\Catalog\Builders;

use Illuminate\Database\Eloquent\Builder;
use Support\Traits\Models\OnHomepage;

final class BrandBuilder extends Builder
{
    use OnHomepage;
}
