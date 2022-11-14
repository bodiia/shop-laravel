<?php

declare(strict_types=1);

namespace Support\Enums;

enum Currency: string
{
    case RUB = 'rub';
    case USD = 'usd';

    public function symbol(): string
    {
        return match ($this) {
            Currency::RUB => '₽',
            Currency::USD => '$',
        };
    }
}
