<?php

declare(strict_types=1);

namespace Database\Factories\Traits;

trait HasHomepageStates
{
    public function homepage(): self
    {
        $attributes = [
            'on_homepage' => true,
        ];

        return $this->state(fn () => $attributes);
    }

    public function sorting(int $value): self
    {
        $attributes = [
            'sorting' => $value,
        ];

        return $this->state(fn () => $attributes);
    }
}
