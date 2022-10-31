<?php

namespace Tests\RequestFactories;

use Worksome\RequestFactories\RequestFactory;

class ResetPasswordRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $password = $this->faker->password(8);

        return [
            'token' => '',
            'email' => 'test@gmail.com',
            'password' => $password,
            'password_confirmation' => $password,
        ];
    }
}
