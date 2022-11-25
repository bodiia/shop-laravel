<?php

declare(strict_types=1);

namespace Support\ValueObjects;

use InvalidArgumentException;
use Stringable;
use Support\Enums\Currency;

final class Price implements Stringable
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

    public function getRaw(): int
    {
        return $this->value;
    }

    public function getValue(): float
    {
        return $this->value / $this->precision;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function __toString(): string
    {
        return number_format($this->getValue(), 0, ',', ' ')
            . ' ' . $this->getCurrency()->symbol();
    }
}
