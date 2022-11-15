<?php

declare(strict_types=1);

namespace Support\ValueObjects;

use Support\Enums\Currency;
use Tests\TestCase;

final class PriceTest extends TestCase
{
    public function test_a_price_creating_success()
    {
        $price = new Price(10000);

        $this->assertEquals(100, $price->getValue());
        $this->assertEquals(10000, $price->getRaw());
        $this->assertEquals(Currency::RUB, $price->getCurrency());
        $this->assertEquals(Currency::RUB->symbol(), $price->getCurrency()->symbol());

        $this->expectException(\InvalidArgumentException::class);

        new Price(-1);
    }
}
