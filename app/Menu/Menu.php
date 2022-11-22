<?php

declare(strict_types=1);

namespace App\Menu;

use Traversable;
use ArrayIterator;
use IteratorAggregate;
use Support\Traits\Makeable;
use Illuminate\Support\Collection;

final class Menu implements IteratorAggregate
{
    use Makeable;

    protected array $items = [];

    public function __construct(MenuItem ...$items)
    {
        $this->items = $items;
    }

    public function getItems(): Collection
    {
        return new Collection($this->items);
    }

    public function add(MenuItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    public function addByCondition(bool|callable $condition, MenuItem $item): self
    {
        if (is_callable($condition) ? call_user_func($condition) : $condition) {
            $this->items[] = $item;
        }

        return $this;
    }

    public function remove(MenuItem $item): self
    {
        $this->items = $this->getItems()
            ->filter(fn (MenuItem $current) => $item !== $current)
            ->toArray();

        return $this;
    }

    public function removeByLink(string $link): self
    {
        $this->items = $this->getItems()
            ->filter(fn (MenuItem $current) => $current->getUrl() !== $link)
            ->toArray();

        return $this;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
