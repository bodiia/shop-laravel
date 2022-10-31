<?php

declare(strict_types=1);

namespace Domain\Auth\Contracts;

use Domain\Auth\DTO\RegisterUserDto;

interface RegisterUserContract
{
    public function handle(RegisterUserDto $registerUserDto);
}
