<?php

declare(strict_types=1);

namespace Support\ValueObjects;

use InvalidArgumentException;
use Support\Enums\Currency;

final class Price
{
    public function __construct(
        private readonly int $value,
        private readonly int $precision = 100,
        private readonly Currency $currency = Currency::RUB
    ) {
        if ($this->value < 0) {
            throw new InvalidArgumentException('Price must be more than zero.');
        }
    }

    public function getValue(): int
    {
        return $this->value / $this->precision;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
