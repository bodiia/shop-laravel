<?php

namespace Tests\RequestFactories;

use Worksome\RequestFactories\RequestFactory;

class SignUpRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $password = $this->faker->password(8);

        return [
            'name' => $this->faker->firstName(),
            'email' => 'test@gmail.com',
            'password' => $password,
            'password_confirmation' => $password,
        ];
    }
}
