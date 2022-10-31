<?php

declare(strict_types=1);

namespace App\Contracts;

interface RouteRegistrar
{
    public function map(): void;
}
